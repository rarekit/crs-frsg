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
 * SplashController
 */
class SplashController extends Controller
{

    protected $_ctrKey = 'splash';

     /**
     * Export method
     * 
     * @param Request $request
     * @param integer $id
     * @return redirect
     */
    public function exportAction()
    {
        $regions = $this->get('manager_factory')
                ->create('region')
                ->findBy(array('active' => true), array());
        
        $success = '';
        foreach ($regions as $region) {
            $result = $this->export($region->getId());
            if ($result) {
                $success .= "$result<br>";
            } 
        }
        $this->addMessage('success', "The xml file was exported at: <br>$success");
        return $this->redirectToRoute("crous_backend_{$this->_ctrKey}_list");
    }
    
    /**
     * export 
     * 
     * @param integer $regionId
     * @return boolean
     */
    protected function export($regionId)
    {
        $splashs = $this->get('manager_factory')
                ->create('splash')
                ->findByRegionId($regionId);
        try {
            $rootNode = new \SimpleXMLElement("<root></root>");
            foreach ($splashs as $item) {
                $rootNode->addChild('splash', $item->getContent());
            }

            $webRoot = $this->get('kernel')->getRootDir() . '/../web';
            $filePath = $webRoot . "/upload/xml/splash";
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $rootNode->saveXML("$filePath/splash-{$regionId}.xml");
            $fullUrl = $this->container->get('request')
                    ->getUriForPath("/upload/xml/splash/splash-{$regionId}.xml");
            return $fullUrl;
        } catch (\Exception $e) {
            return false;
        }
    }

}
