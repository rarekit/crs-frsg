<?php

/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crous\Bundle\BackendBundle\Manager\Base;

use Doctrine\ORM\EntityManager;
use Crous\Bundle\BackendBundle\Entity\Base\EntityInterface;

/**
 * BaseManager
 */
class BaseManager implements ManagerInterface {

    protected $_entityManager;
    protected $_entityName = null;

    /**
     * @param \Doctrine\ORM\EntityManager $manager
     */
    public function __construct(EntityManager $manager, $entityName = null) {
        $this->_entityManager = $manager;
        if (is_null($this->_entityName)) {
            $this->_entityName = $entityName;
        }
    }

    /* (non-PHPdoc)
     * @see \Crous\Bundle\BackendBundle\Manager\Base\ManagerInterface::getRepository()
     */

    public function getRepository() {
        if (is_null($this->_entityName)) {
            return null;
        }
        return $this->_entityManager->getRepository("CrousBackendBundle:{$this->_entityName}");
    }

    /**
     * @param object $object
     */
    public function save(EntityInterface $entity, $isFlush = true) {
        try {
            $this->_entityManager->persist($entity);
            if ($isFlush) {
                $this->_entityManager->flush();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param object $entity
     * @param string $isFlush
     */
    public function delete(EntityInterface $entity, $isFlush = true) {
        try {
            $this->_entityManager->remove($entity);
            if ($isFlush) {
                $this->_entityManager->flush();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * get house by criterias
     * 
     * @param array   $criteria
     * @param array   $order
     * @param integer $limit
     * @param integer $offset
     * @return null|array
     */
    public function findBy($criteria, $order, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * get total of records by criterias
     * 
     * @param type $criteria
     * @return integer
     */
    public function countBy($criteria = array())
    {
        return $this->getRepository()->countBy($this->_filter($criteria));
    }
    
    /**
     * filters
     * 
     * @param array $criteria
     * @return array
     */
    protected function _filter($criteria)
    {
        return $criteria;
    }

}
