<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * SplashController
 */
class SplashController extends BaseController
{
    /**
     * index action
     * 
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $csrf = $this->get('form.csrf_provider');
        $token = $csrf->generateCsrfToken('splash');
        
        $page = $request->get('page', 1);
        $limit = $this->container->getParameter('item_per_page');
        $offset = ($page - 1) * $limit;
        
        $splashs = $this->get('splash_manager')->getSplashs(array(), array(), $limit, $offset);
        $totalRecord = $this->get('splash_manager')->getTotal();
        $pagination = $this->createPagination($totalRecord, $page);
        
        return $this->render('CrousBackendBundle:Splash:index.html.twig', array(
            'splashs'    => $splashs,
            'pagination' => $pagination,
            'token'      => $token
        ));
    }

    /**
     * add action
     * 
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function addAction(Request $request, $id)
    {
        if (!is_null($id)) {
            $entity = $this->get('entity_factory')->get('Splash', $id);
            if (is_null($entity)) {
                throw $this->createNotFoundException();
            }
        } else {
            $entity = $this->get('entity_factory')->create('Splash');
        }

        $formType = $this->get('form_factory')->create('Splash');
        $form = $this->createForm($formType, $entity);
        if ('POST' == $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $result = $this->get('splash_manager')->save($entity);
                if ($result) {
                    $message = !is_null($id) ? 'Your changes were saved' : 'The object was created';
                    $this->addMessage('success', $message);
                    return $this->redirectToRoute('crous_backend_splash_add', array(
                                'id' => $entity->getId())
                    );
                } else {
                    $message = !is_null($id) ? 'Error occurred while updating' 
                            : 'Error occurred while creating object';
                    $this->addMessage('error', $message);
                }
            } else {
                $this->addMessage('error', 'The input values is invalid');
            }
        }

        return $this->render('CrousBackendBundle:Splash:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    /**
     * Delete action
     * 
     * @param Request $request
     * @param integer $id
     * @return void
     * @throws NotFoundException
     */
    public function deleteAction(Request $request, $id)
    {
        //Check token before deleting
        $token = $request->get('token', '');
        $csrf = $this->get('form.csrf_provider');
        if (!$csrf->isCsrfTokenValid('splash', $token)) {
            throw $this->createNotFoundException();
        }
        
        if (!is_null($id)) {
            $entity = $this->get('entity_factory')->get('Splash', $id);
            if (is_null($entity)) {
                throw $this->createNotFoundException();
            }
            
            $result = $this->get('splash_manager')->delete($entity);
            if ($result) {
                $this->addMessage('success', 'The object was deleted');
            } else {
                $this->addMessage('error', 'Error occurred while updating');
            }
        } 
        
        return $this->redirectToRoute('crous_backend_splash_list');
    }

}
