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
 * UserSubscriber
 *
 */
class UserSubscriber implements EventSubscriberInterface
{
    protected $_container;
    protected $_currentPasswd;

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
            FormEvents::PRE_SET_DATA => 'preSet',
            FormEvents::POST_BIND => 'postBind',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function preSet(FormEvent $event)
    {
        $user = $event->getData();
        if ($user) {    
            $this->_currentPasswd = $user->getPassword();
        }
    }
    
    /**
     * @param FormEvent $event
     */
    public function postBind(FormEvent $event) {
        $user = $event->getData();
        $factory = $this->_container->get('security.encoder_factory');
        
        $encoder = $factory->getEncoder($user);
        $password = $user->getPassword();
        if (!empty($password)) {
            $newPassword = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($newPassword);
        } else {
            $user->setPassword($this->_currentPasswd);
        }   

    }
}
