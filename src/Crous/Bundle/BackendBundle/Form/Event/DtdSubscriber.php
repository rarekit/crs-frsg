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
        );
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
