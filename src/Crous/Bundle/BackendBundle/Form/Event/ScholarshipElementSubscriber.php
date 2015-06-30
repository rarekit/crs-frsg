<?php

/*
 * This file is part of the Crous package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crous\Bundle\BackendBundle\Form\Event;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ScholarshipElementSubscriber
 *
 */
class ScholarshipElementSubscriber implements EventSubscriberInterface
{

    protected $_container;
    protected $_imagePath;
    protected $_webRoot;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
        $this->_webRoot = $this->_container->get('kernel')->getRootDir() . '/../web';
        $this->_imagePath = "/upload/scholarship_elements/";
    }

    /**
     * @return multitype:string 
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_BIND => 'postBind',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function postBind(FormEvent $event)
    {
        $data = $event->getData();
        $pid = $this->_container->get('request')->get('pid', null);
        if ($pid != NULL) {
            $scholarship = $this->_container->get('entity_factory')->get('scholarship', $pid);
            $data->setScholarship($scholarship);
        }

        if (!is_null($data->file)) {
            if (!is_dir($this->_webRoot . $this->_imagePath)) {
                mkdir($this->_webRoot . $this->_imagePath, 0755, true);
            }
            $imageName = date('Ymd') . "_" . $data->file->getClientOriginalName();
            $imageUrl = $this->_imagePath . $imageName;
            $data->file->move($this->_webRoot . $this->_imagePath, $imageName);
            $data->setImageUrl($imageUrl);
            
            $fullUrl = $this->_container->get('request')->getUriForPath($imageUrl);
            $imageShortUrl = $this->_container->get('url_api')->shorten($fullUrl);
            $data->setImageShortUrl($imageShortUrl);

            if (file_exists($this->_webRoot . $imageUrl)) {
                $thumbnailPath = $this->_imagePath . "thumb/";
                if (!is_dir($this->_webRoot . $thumbnailPath)) {
                    mkdir($this->_webRoot . $thumbnailPath, 0755, true);
                }
                $thumbnailUrl = $thumbnailPath . $imageName;
                $this->_container->get('image.handling')->open($this->_webRoot . $imageUrl)
                        ->resize(150, 150)
                        ->save($this->_webRoot . $thumbnailUrl);
                $data->setThumbnailUrl($thumbnailUrl);
            }
        }
        
        if (!is_null($data->getSharingUrl())) {
            $shortUrl = $this->_container->get('url_api')->shorten($data->getSharingUrl());
            $data->setSharingShortUrl($shortUrl);
        }
    }
}
