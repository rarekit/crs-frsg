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
 * EntityFactory
 */
class EntityFactory {

    protected $_container;
    protected $_entities;

    /**
     * Constructor
     * 
     * @param ContainerInterface $container
     * @param array $entities
     */
    public function __construct(ContainerInterface $container, $entities)
    {
        $this->_container = $container;   
        $this->_entities = $entities;
    }

    /**
     * create an object by class name
     * 
     * @param string $name
     * @param array  $args
     * @return mixed
     */
    public function create($name, $args=array())
    {
        $entity = null;
        if (isset($this->_entities[strtolower($name)])) {
            $entity = new $this->_entities[strtolower($name)]['class']();
        } 
        
        return $entity;
    }

    /**
     * get an object by id
     * 
     * @param string $name
     * @param array  $id
     * @return mixed
     */
    public function get($name, $id)
    {
        return $this->_container->get('doctrine')->getManager()
                ->getRepository("CrousBackendBundle:" . ucfirst($name))
                ->find($id);
    }
}
  
