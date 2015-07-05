<?php

namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CRUDController extends Controller
{

    /** @var string * */
    protected $_ctrKey = null;

    /**
     * index action
     * 
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $csrf = $this->get('form.csrf_provider');
        $token = $csrf->generateCsrfToken($this->_ctrKey);

        $page = $request->get('page', 1);
        $limit = $this->container->getParameter('item_per_page');
        $offset = ($page - 1) * $limit;

        $filterType = $this->get('form_factory')->createFilter($this->_ctrKey);
        $filterData = array();
        if (!is_null($filterType)) {
            $form = $this->createForm($filterType);
            if ($request->isMethod('GET')) {
                $form->bind($request);
                $filterData = $form->getData();
            }
        }

        $manager = $this->get('manager_factory')->create($this->_ctrKey);
        $entities = $manager->findBy($filterData, array(), $limit, $offset);
        $totalRecord = $manager->countBy($filterData);
        $pagination = $this->createPagination($totalRecord, $page);

        $template = 'CrousBackendBundle:' . ucfirst($this->_ctrKey) . ':index.html.twig';
        return $this->render($template, array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    'token' => $token,
                    'filterForm' => isset($form) ? $form->createView() : null
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
            $entity = $this->get('entity_factory')->get($this->_ctrKey, $id);
            if (is_null($entity)) {
                throw $this->createNotFoundException();
            }
        } else {
            $entity = $this->get('entity_factory')->create($this->_ctrKey);
        }

        $formType = $this->get('form_factory')->create($this->_ctrKey);
        $form = $this->createForm($formType, $entity);
        if ('POST' == $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $manager = $this->get('manager_factory')->create($this->_ctrKey);
                $result = $manager->save($entity);
                if ($result) {
                    $message = !is_null($id) ? 'Your changes were saved' : 'The object was created';
                    $this->addMessage('success', $message);
                    $editRoute = 'crous_backend_' . strtolower($this->_ctrKey) . '_add';
                    return $this->redirectToRoute($editRoute, array(
                                'id' => $entity->getId())
                    );
                } else {
                    $message = !is_null($id) ? 'Error occurred while updating' : 'Error occurred while creating object';
                    $this->addMessage('error', $message);
                }
            } else {
                $this->addMessage('error', 'The input values is invalid');
            }
        }

        $template = 'CrousBackendBundle:' . ucfirst($this->_ctrKey) . ':add.html.twig';
        return $this->render($template, array(
                    'form' => $form->createView(),
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
        if (!$csrf->isCsrfTokenValid($this->_ctrKey, $token)) {
            throw $this->createNotFoundException();
        }

        if (!is_null($id)) {
            $entity = $this->get('entity_factory')->get($this->_ctrKey, $id);
            if (is_null($entity)) {
                throw $this->createNotFoundException();
            }

            $result = $this->get('manager_factory')
                    ->create($this->_ctrKey)
                    ->delete($entity);
            if ($result) {
                $this->addMessage('success', 'The object was deleted');
            } else {
                $this->addMessage('error', 'Error occurred while updating');
            }
        }
        $listRoute = 'crous_backend_' . strtolower($this->_ctrKey) . '_list';
        return $this->redirectToRoute($listRoute);
    }

    /**
     * Delete action
     * 
     * @param Request $request
     * @param integer $id
     * @return void
     * @throws NotFoundException
     */
    public function deleteImageAction(Request $request, $id)
    {
        if (!is_null($id)) {
            $entity = $this->get('entity_factory')->get($this->_ctrKey, $id);
            if (is_null($entity)) {
                throw $this->createNotFoundException();
            }


            $this->_webRoot = $this->get('kernel')->getRootDir() . '/../web';
            $image = $entity->getImageUrl();
            if (!empty($image)) {
                if (file_exists($this->_webRoot . $image)) {
                    unlink($this->_webRoot . $image);
                }
                $entity->setImageUrl('');
            }
            $thumbnail = $entity->getThumbnailUrl();
            if (!empty($thumbnail)) {
                if (file_exists($this->_webRoot . $thumbnail)) {
                    unlink($this->_webRoot . $thumbnail);
                }
                $entity->setThumbnailUrl('');
            }

            $result = $this->get('manager_factory')
                    ->create($this->_ctrKey)
                    ->save($entity);
            if ($result) {
                $this->addMessage('success', 'The image was deleted');
            } else {
                $this->addMessage('error', 'Error occurred while deleted');
            }
        }
        $listRoute = 'crous_backend_' . strtolower($this->_ctrKey) . '_add';
        return $this->redirectToRoute($listRoute, array('id' => $id));
    }

    /**
     * add flash message
     * 
     * @param string $type  error|warning|success
     * @param string $message
     */
    public function addMessage($type, $message)
    {
        $this->addFlash($type, $this->get('translator')->trans($message));
    }

    /**
     * create a pagination
     * 
     * @param type $total
     * @param type $current
     * @return type
     */
    public function createPagination($total, $current)
    {
        $perPage = $this->container->getParameter('item_per_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $current > 1 ? $current - 1 : 1;
        $nextPage = $current < $lastPage ? $current + 1 : $lastPage;

        return $this->renderView('CrousBackendBundle:Block:pagination.html.twig', array(
                    'lastPage' => $lastPage,
                    'previousPage' => $previousPage,
                    'currentPage' => $current,
                    'nextPage' => $nextPage,
                    'total' => $total
        ));
    }

}
