<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ExportController
 */
class ExportController extends Controller
{
    const TYPE_SPLASH = 'SPLASH';
    const TYPE_HOUSE = 'HOUSE';
    const TYPE_SERVICE = 'SERVICE';
    const TYPE_ONLINESERVICE = 'ONLINESERVICE';
    const TYPE_CULTURALEVENT = 'CULTURALEVENT';

    const STATE_SUCCESS = 'SUCCESSFUL';
    const STATE_FAILED = 'FAILED';


    public function indexAction() 
    {
        $types = array(
            self::TYPE_SPLASH => 'Splash',
            self::TYPE_HOUSE => 'House',
            self::TYPE_SERVICE => 'Service',
            self::TYPE_ONLINESERVICE => 'Online Services',
            self::TYPE_CULTURALEVENT => 'Event',        
        ); 

        $type = $this->getRequest()->get('type');
        $regionMgr = $this->get('manager_factory')->create('region');
        $exportMgr = $this->get('manager_factory')->create('exportStatus');

        $regions = $regionMgr->getAllByKey();
        $exportStatus = $exportMgr->getAllSortByType();

        return $this->render('CrousBackendBundle:Export:index.html.twig', array(
            'regions'       => $regions,
            'exportStatus'  => $exportStatus,
            'types'         => $types,
            'active'        => $type,
        ));
    }

    public function processAction()
    {
        $type = $this->getRequest()->get('type');
        $regionId = $this->getRequest()->get('regionId');

        if ($type != self::TYPE_CULTURALEVENT && $regionId == null) {
            throw $this->createNotFoundException();
        }

        switch ($type) {
        case self::TYPE_SPLASH:
            $ret = $this->exportSplash($regionId);
            $this->updateStatus($regionId, $type, $ret);
            break;
        case self::TYPE_HOUSE:
            $ret = $this->exportHouse($regionId);
            $this->updateStatus($regionId, $type, $ret);
            break;
        case self::TYPE_SERVICE:
            $ret = $this->exportService($regionId);
            $this->updateStatus($regionId, $type, $ret);
            break;
        case self::TYPE_ONLINESERVICE:
            $ret = $this->exportOnlineService($regionId);
            $this->updateStatus($regionId, $type, $ret);
            break;
        case self::TYPE_CULTURALEVENT:
            $ret = $this->exportEvent();
            $this->updateStatus($regionId, $type, $ret);
            break;
        default:
            break;
        } 
        return $this->redirectToRoute('crous_backend_export_list', array('type' => $type));
    }

    public function updateStatus($regionId, $type, $state = true)
    {
        $statusMgr = $this->get('manager_factory')->create('exportStatus');
        $status = $statusMgr->getEntry($regionId, $type);
        if (!$status) {
            $status = $this->get('entity_factory')->create('exportStatus');
            if (!is_null($regionId)) {
                $region = $this->get('entity_factory')->get('region', $regionId);
                $status->setRegion($region);
            } elseif ($type != self::TYPE_CULTURALEVENT) {
                throw $this->createNotFoundException();
            }
        }
        $state = ($state == true) ? self::STATE_SUCCESS : self::STATE_FAILED;
        $status->setLastState($state);
        $status->setLastAttempt(new \DateTime());
        $status->setType($type);
        $statusMgr->save($status);
    }

    /**
     * upload ftp
     *
     * @param string $filename
     * @param string $file 
     *
     * @return boolean
     */
    protected function uploadFtp($filename, $file)
    {
        if (!file_exists($file)) {
            return false;
        }

        $settings = $this->get('manager_factory')->create('params')->getParams();
        $ftpHost = $settings['export_ftp_host'];
        $ftpDir = $settings['export_ftp_dir'];
        $ftpUser = $settings['export_ftp_user'];
        $ftpPasswd = $settings['export_ftp_passwd'];

        $conn = ftp_connect($ftpHost, 21, 10);
        if ($conn == false) {
            $this->addFlash('error', 'Can\'t connect to ftp server');
            return false;
        }

        $ret = ftp_login($conn, $ftpUser, $ftpPasswd);
        if ($ret) {
            $path = "{$ftpUser}/{$ftpPasswd}";
            $target = "{$ftpDir}/{$path}/{$filename}";
            $this->ftp_mksubdirs($conn,$ftpDir, $path);
            if (ftp_put($conn, $target, $file, FTP_ASCII)) {
                $this->addFlash('success', 'Export successful');
                return true;
            } else {
                $this->addFlash('error', 'Export failed because can\'t upload file to server');
                return false;
            }
        } else {
            $this->addFlash('error', 'Can\'t access to ftp server');
            return false;
        }
    }

    /**
     * create recursive directory
     *
     * @param object $ftpcon
     * @param string $ftpbasedir
     * @param string $ftpath
     *
     */
    function ftp_mksubdirs($ftpcon,$ftpbasedir,$ftpath){
        @ftp_chdir($ftpcon, $ftpbasedir);
        $parts = explode('/',$ftpath);
        foreach($parts as $part){
            if(!@ftp_chdir($ftpcon, $part)){
                ftp_mkdir($ftpcon, $part);
                ftp_chdir($ftpcon, $part);
            }
        }
    }

    /**
     * export splash 
     * 
     * @param integer $regionId
     * @return boolean
     */
    protected function exportSplash($regionId)
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
            $file = "$filePath/splash-{$regionId}.xml";
            $rootNode->saveXML($file);
            $ret = $this->uploadFtp("splash-{$regionId}.xml", $file);

            return $ret;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * export house
     * 
     * @param integer $regionId
     * @return boolean
     */
    protected function exportHouse($regionId)
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
            $file = "$filePath/house-{$regionId}.xml";
            $rootNode->saveXML($file);
            $ret = $this->uploadFtp("house-{$regionId}.xml", $file);

            return $ret;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * export service
     * 
     * @param integer $regionId
     * @return boolean
     */
    protected function exportService($regionId)
    {
        $splashs = $this->get('manager_factory')
                ->create('service')
                ->findByRegionId($regionId);
        try {
            $rootNode = new \SimpleXMLElement("<root></root>");
            foreach ($splashs as $item) {
                $node = $rootNode->addChild('service', $item->getContent());
                $node->addAttribute('id', $item->getId());
                $imageUrl = '';
                if ($item->getImageUrl() != '') {
                    $imageUrl = $this->container->get('request')->getUriForPath($item->getImageUrl());
                }
                $node->addAttribute('title', $item->getTitle());
                $node->addAttribute('short_desc', $item->getShortDesc());
                $node->addAttribute('lat', $item->getLat());
                $node->addAttribute('lon', $item->getLon());
                $node->addAttribute('zone', $item->getZone());
            }

            $webRoot = $this->get('kernel')->getRootDir() . '/../web';
            $filePath = $webRoot . "/upload/xml/service";
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $file = "$filePath/service-{$regionId}.xml";
            $rootNode->saveXML($file);
            $ret = $this->uploadFtp("service-{$regionId}.xml", $file);
            
            return $ret;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * export online service
     * 
     * @param integer $regionId
     * @return boolean
     */
    protected function exportOnlineService($regionId)
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
            $file = "$filePath/online-service-{$regionId}.xml";
            $rootNode->saveXML($file);
            $ret = $this->uploadFtp("online-service-{$regionId}.xml", $file);
            
            return $ret;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * export event
     * 
     * @param integer $regionId
     * @return boolean
     */
    protected function exportEvent()
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
            $file = "$filePath/event.xml";
            $rootNode->saveXML($file);
            $ret = $this->uploadFtp("event.xml", $file);
            
            return $ret;
        } catch (\Exception $e) {
            return false;
        }
    }


}
