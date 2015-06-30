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
 * ScholarshipController
 */
class ScholarshipElementController extends Controller
{
    protected $_ctrKey = 'scholarshipElement';

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

        if ($request->get('pid') == null) {
            throw $this->createNotFoundException();
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

                    $params['id'] = $entity->getId();
                    $params['pid'] = $request->get('pid');
                    return $this->redirectToRoute($editRoute, $params);
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
            'pid' => $request->get('pid')
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
        if (!is_null($id)) {
            $entity = $this->get('entity_factory')->get($this->_ctrKey, $id);
            $pid = $entity->getScholarship()->getId();
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
        $listRoute = 'crous_backend_scholarship_add';
        return $this->redirectToRoute($listRoute, array('id'=>$pid));
    }



}
