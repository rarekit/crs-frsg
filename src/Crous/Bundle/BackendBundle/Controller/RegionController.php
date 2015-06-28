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
 * RegionController
 */
class RegionController extends Controller
{

    protected $_ctrKey = 'region';

    public function activeAction(Request $request)
    {
        //Check token before active
        $token = $request->get('token', '');
        $csrf = $this->get('form.csrf_provider');
        if (!$csrf->isCsrfTokenValid($this->_ctrKey, $token)) {
            throw $this->createNotFoundException();
        }
        
        $id = $request->get('id');
        $type = $request->get('type');
        if (!is_null($id)) {
            $entity = $this->get('entity_factory')->get($this->_ctrKey, $id);
            if (is_null($entity)) {
                throw $this->createNotFoundException();
            }
            
            $entity->setActive(false);
            if ($type == 1) {
                $entity->setActive(true);
            }
            
            $result = $this->get('manager_factory')
                    ->create($this->_ctrKey)
                    ->save($entity);
            if ($result) {
                $this->addMessage('success', 'The object was updated');
            } else {
                $this->addMessage('error', 'Error occurred while updating');
            }
        } else {
            throw $this->createNotFoundException();
        }
        
        $listRoute = 'crous_backend_flux_dashboard';
        return $this->redirectToRoute($listRoute);
    }

}
