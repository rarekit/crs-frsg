<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ManagerFactory
 */
class ManagerFactory {

    protected $_container;
    protected $_managers;

    /**
     * Constructor
     * 
     * @param ContainerInterface $container
     * @param array $managers
     */
    public function __construct(ContainerInterface $container, $managers)
    {
        $this->_container = $container;   
        $this->_managers = $managers;
    }

    /**
     * create an manager by class name
     * 
     * @param string $name
     * @param array  $args
     * @return mixed
     */
    public function create($name)
    {
        $manager = null;
        if (isset($this->_managers[$name])) {
            $doctrineMgr = $this->_container->get('doctrine')->getManager();
            $manager = new $this->_managers[$name]['class']($doctrineMgr);
        } 
        
        return $manager;
    }
}
  
