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
 * DtdSubscriber
 *
 */
class DtdSubscriber implements EventSubscriberInterface
{

    protected $_container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
    }

    /**
     * @return multitype:string 
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::POST_BIND => 'postBind',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function postBind(FormEvent $event)
    {
        $data = $event->getData();
        $regions = $this->_container->get('manager_factory')
                ->create('region')
                ->findBy(array(), array());
        $feedMgr = $this->_container->get('manager_factory')
                ->create('feed');
        foreach ($regions as $region) {
            $feed = $feedMgr->findOneBy(array('dtd' => $data, 'region' => $region));
            if (is_null($feed)) {
                $feed = $this->_container->get('entity_factory')
                        ->create('feed');
            }
            
            $settings = $this->_container->get('manager_factory')->create('params')->getParams();
            $url = $settings['dtd_url'] . "{$region->getName()}-{$data->getFilename()}";
            $feed->setDtd($data)
                ->setRegion($region)
                ->setFilename("{$region->getName()}-{$data->getFilename()}")
                ->setEmail($region->getEmail())
                ->setUrl($url)
                ->setActive(true)
                ;
            $feedMgr->save($feed, false);
        }
    }

    
    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        if (is_null($data->getId())) {
            $form->add('filename', null, array(
                'label' => 'Filename on FTP',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Filename on FTP',
                ),
                'required' => true
            ));
        }
        
        $choices = array();
        $syncPeriod = $this->_container->getParameter('sync_period');
        foreach ($syncPeriod as $val) {
            $choices[$val] = $val;
        }
        
        $form->add('syncPeriod', 'choice', array(
            'label' => 'Sync Period',
            'choices' => $choices,
            'empty_value' => 'Select a value',
            'attr' => array(
                'class' => 'form-control',
            ),
            'required' => true
        ));
    }

}
