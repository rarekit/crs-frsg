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
 * RegionSubscriber
 *
 */
class RegionSubscriber implements EventSubscriberInterface
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
            FormEvents::PRE_BIND => 'preBind',
            FormEvents::POST_BIND => 'postBind',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function preBind(FormEvent $event)
    {
    }
    
    /**
     * @param FormEvent $event
     */
    public function postBind(FormEvent $event) {
        $region = $event->getData();
        if ($region->getActive() == null) {
            $region->setActive(true);
        } 
    }
}
