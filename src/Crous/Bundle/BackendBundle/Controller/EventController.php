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
 * EventController
 */
class EventController extends Controller
{
    protected $_ctrKey = 'event';
    
    /**
     * Export method
     * 
     * @param Request $request
     * @param integer $id
     * @return redirect
     */
    public function exportAction()
    {
        $result = $this->export();
        
        $this->addMessage('success', "The xml file was exported at: <br>$result");
        return $this->redirectToRoute("crous_backend_event_list");
    }
    
    /**
     * export 
     * 
     * @param integer $regionId
     * @return boolean
     */
    protected function export()
    {
        $events = $this->get('manager_factory')
                ->create('event')
                ->findBy(array(), array());
        try {
            $rootNode = new \SimpleXMLElement("<root></root>");
            foreach ($events as $item) {
                $node = $rootNode->addChild('event');
                $node->addChild('id', $item->getId());
                $imageUrl = '';
                if ($item->getImageUrl() != '') {
                    $imageUrl = $this->container->get('request')->getUriForPath($item->getImageUrl());
                }
                $node->addChild('image', $imageUrl);
                $node->addChild('title', $item->getTitle());
                $node->addChild('texte', $item->getText());
                
                $date = '';
                if ($item->getEventDate() != null) {
                    $date = $item->getEventDate()->format('jS F Y g:i');
                }
                $node->addChild('date', $date);
                $node->addChild('lien', $item->getsharingUrl());
            }

            $webRoot = $this->get('kernel')->getRootDir() . '/../web';
            $filePath = $webRoot . "/upload/xml/event";
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $rootNode->saveXML("$filePath/event.xml");
            $fullUrl = $this->container->get('request')
                    ->getUriForPath("/upload/xml/event/event.xml");
            return $fullUrl;
        } catch (\Exception $e) {
            return false;
        }
    }
}
