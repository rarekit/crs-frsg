<?php

namespace Crous\Bundle\BackendBundle\DataFixtures\ORM\LoadUser;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load user, role data
 */
class LoadUserRoleData implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    /**
     * Set container
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Function to load data
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Setup roles and group
        $roles = array(
            array('Administrator','ROLE_ADMIN',1),
            array('Standard User','ROLE_USER',0),
            array('Guest','ROLE_GUEST',0),          
        );
        
        $users = array(
            array('admin', 'admin', 'Johnny', 'Depp', 'ROLE_ADMIN', 'admin@crous.com', true),
        );
        
        /* @var $roleManager \Crous\Bundle\BackendBundle\Manager\RoleManager */
        $roleManager = $this->container->get('role_manager');  
        foreach ($roles as $item) {
            /* @var $group \Crous\Bundle\BackendBundle\Entity\Role */
            $role = $roleManager->createObject();
            $role->setName($item[0])
                  ->setRole($item[1])
                  ->setType($item[2])  
                  ->setEnabled(true)
            ;
            $roleManager->save($role);
        }
        
        /* @var $userManager \Crous\Bundle\BackendBundle\Manager\UserManager */
        $userManager = $this->container->get('user_manager');
        foreach ($users as $item) {
            /* @var $user \Crous\Bundle\BackendBundle\Entity\User */
            $user = $userManager->createObject();
            $user->setUsername($item[0])
                    ->setPassword($item[1])
                    ->setFirstname($item[2])
                    ->setLastname($item[3])
                    ->setEmail($item[5])
                    ->setLocked(false)
                    ->setExpired(false)
                    ->setEnabled(true)
            ;
            
            $role = $roleManager->getRepository()->findOneBy(array('role'=>$item[4]));
            if ($role instanceof \Crous\Bundle\BackendBundle\Entity\Role) {
                $user->setRole($role);            
            }
            
            //Encrypt password
            $factory = $this->container->get('security.encoder_factory');
            $salt = $this->container->getParameter('salt');
            $encoder = $factory->getEncoder($user);        
            $password = $encoder->encodePassword($user->getPassword(), $salt);  
            
            $user->setPassword($password);
            $userManager->save($user);
        }
    }

}
