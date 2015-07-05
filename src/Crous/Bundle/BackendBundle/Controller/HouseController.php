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
 * HouseController
 */
class HouseController extends Controller
{
    protected $_ctrKey = 'house';
    
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
        $this->addMessage('success', "The xml files was exported at: <br>$success");
        return $this->redirectToRoute('crous_backend_house_list');
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
                ->create('house')
                ->findByRegionId($regionId);
        try {
            $rootNode = new \SimpleXMLElement("<root></root>");
            foreach ($splashs as $item) {
                $node = $rootNode->addChild('residence');
                $node->addAttribute('id', $item->getId());
                $node->addAttribute('title', $item->getTitle());
                $node->addAttribute('short_desc', $item->getShortDesc());
                $node->addAttribute('lat', $item->getLat());
                $node->addAttribute('lon', $item->getLon());
                $node->addAttribute('zone', $item->getZone());
                $node->addChild('infos', $item->getInfos());
                $node->addChild('services', $item->getServices());
                $node->addChild('contact', $item->getContact());
            }

            $webRoot = $this->get('kernel')->getRootDir() . '/../web';
            $filePath = $webRoot . "/upload/xml/house";
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $rootNode->saveXML("$filePath/house-{$regionId}.xml");
            
            $fullUrl = $this->container->get('request')
                    ->getUriForPath("/upload/xml/house/house-{$regionId}.xml");
            return $fullUrl;
        } catch (\Exception $e) {
            return false;
        }
    }
}
