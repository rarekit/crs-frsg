<?php

/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crous\Bundle\BackendBundle\Controller;

use Crous\Bundle\BackendBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * UserController
 */
class UserController extends Controller
{

    protected $_ctrKey = 'user';

    /**
     * index action
     * 
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request, $id)
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
                    'id' => $id,
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
    public function addCustomAction(Request $request, $type, $id)
    {
        $csrf = $this->get('form.csrf_provider');
        $token = $csrf->generateCsrfToken($this->_ctrKey);

        if ($type == 1) {
            $page = $request->get('page', 1);
            $limit = $this->container->getParameter('user_item_per_page');
            $offset = ($page - 1) * $limit;
            $manager = $this->get('manager_factory')->create($this->_ctrKey);
            $entities = $manager->findBy(array(), array(), $limit, $offset);
            if (count($entities)) {
                $entity = $entities[0];
            } else {
                $entity = $this->get('entity_factory')->create($this->_ctrKey);
            }
        } elseif ($type == 2) {

            if (!is_null($id)) {
                $entity = $this->get('entity_factory')->get($this->_ctrKey, $id);
                if (is_null($entity)) {
                    throw $this->createNotFoundException();
                }
            } else {
                $entity = $this->get('entity_factory')->create($this->_ctrKey);
            }
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
                                'type' => 2,
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

        if ($type == 2) {
            $page = $request->get('page', 1);
            $limit = $this->container->getParameter('user_item_per_page');
            $offset = ($page - 1) * $limit;
            $manager = $this->get('manager_factory')->create($this->_ctrKey);
            $entities = $manager->findBy(array(), array(), $limit, $offset);
        }
        $totalRecord = $manager->countBy(array());

        $template = 'CrousBackendBundle:' . ucfirst($this->_ctrKey) . ':index.html.twig';
        return $this->render($template, array(
                    'entity' => $entity,
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'token' => $token,
                    'pagination' => $this->createCustomPagination($totalRecord, $page)
        ));
    }

    /**
     * create a pagination
     * 
     * @param type $total
     * @param type $current
     * @return type
     */
    public function createCustomPagination($total, $current)
    {
        $perPage = $this->container->getParameter('user_item_per_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $current > 1 ? $current - 1 : 1;
        $nextPage = $current < $lastPage ? $current + 1 : $lastPage;

        return $this->renderView('CrousBackendBundle:Block:pagination-custom.html.twig', array(
                    'lastPage' => $lastPage,
                    'previousPage' => $previousPage,
                    'currentPage' => $current,
                    'nextPage' => $nextPage,
                    'total' => $total
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
        $listRoute = 'crous_backend_' . strtolower($this->_ctrKey) . '_add';
        return $this->redirectToRoute($listRoute);
    }

}
