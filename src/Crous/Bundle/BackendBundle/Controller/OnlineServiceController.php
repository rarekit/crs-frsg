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

/**
 * OnlineServiceController
 */
class OnlineServiceController extends Controller
{
    protected $_ctrKey = 'onlineService';
    
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
        return $this->redirectToRoute("crous_backend_onlineservice_list");
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
                ->create('onlineService')
                ->findByRegionId($regionId);
        try {
            $rootNode = new \SimpleXMLElement("<root></root>");
            foreach ($splashs as $item) {
                $node = $rootNode->addChild('online');
                $node->addAttribute('id', $item->getId());
                $imageUrl = '';
                if ($item->getImageUrl() != '') {
                    $imageUrl = $this->container->get('request')->getUriForPath($item->getImageUrl());
                }
                $node->addAttribute('image', $imageUrl);
                $node->addAttribute('title', $item->getTitle());
                $node->addAttribute('short_desc', $item->getShortDesc());
                $node->addAttribute('link', $item->getLink());
            }

            $webRoot = $this->get('kernel')->getRootDir() . '/../web';
            $filePath = $webRoot . "/upload/xml/online-service";
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $rootNode->saveXML("$filePath/online-service-{$regionId}.xml");
            $fullUrl = $this->container->get('request')
                    ->getUriForPath("/upload/xml/online-service/online-service-{$regionId}.xml");
            return $fullUrl;
        } catch (\Exception $e) {
            return false;
        }
    }
    
}
