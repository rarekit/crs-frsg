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
 * ParamsSubscriber
 *
 */
class ParamsSubscriber implements EventSubscriberInterface
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
            $form->add('name', null, array(
                'label' => 'Name',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Name',
                ),
                'required' => true
            ));
        } else {
            $form->add('name', null, array(
                'label' => 'Name',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Name',
                    'readonly' => 'readonly'
                ),
                'required' => true
            ));

        }

        $form->add('value', null, array(
            'label' => 'Value',
            'attr' => array(
                'class' => 'form-control',
            ),
            'required' => true
        ));
    }

}
