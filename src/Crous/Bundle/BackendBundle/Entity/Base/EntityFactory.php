<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Entity\Base;

use Doctrine\ORM\EntityManager;

/**
 * EntityFactory
 */
class EntityFactory {

    protected $_entityManager;

    public function __construct(EntityManager $manager)
    {
        $this->_entityManager = $manager;   
    }

    public function create($name, $args=array())
    {
        switch($name) {
            case 'User':
                $entity = new \Crous\Bundle\BackendBundle\Entity\User();
                break;
            case 'Role':
                $entity = new \Crous\Bundle\BackendBundle\Entity\Role();
                break;
            case 'Region':
                $entity = new \Crous\Bundle\BackendBundle\Entity\Region();
                break;
            case 'Splash':
                $entity = new \Crous\Bundle\BackendBundle\Entity\Splash();
                break;
            default:
                $entity = null;
        }

        return $entity;
    }

    public function get($name, $id)
    {
        return $this->_entityManager->getRepository("CrousBackendBundle:{$name}")->find($id);
    }
}
  
