<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Manager;

/**
 * UserManager
 */
class UserManager {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @param \Doctrine\ORM\EntityManager $manager
     */
    public function __construct(\Doctrine\ORM\EntityManager $manager) {
        $this->entityManager = $manager;
    }

    /* (non-PHPdoc)
     * @see \Aseagle\Bundle\CoreBundle\Manager\ObjectManagerInterface::getRepository()
     */
    public function getRepository() {
        return $this->entityManager->getRepository('CrousBackendBundle:User');
    }

    /* (non-PHPdoc)
     * @see \Aseagle\Bundle\CoreBundle\Manager\ObjectManagerInterface::createObject()
     */
    public function createObject() {
        return new \Crous\Bundle\BackendBundle\Entity\User();
    }

    /* (non-PHPdoc)
     * @see \Aseagle\Bundle\CoreBundle\Manager\ObjectManagerInterface::getObject()
     */
    public function getObject($gid) {
        return $this->getRepository()->find($gid);
    }

    /**
     * @param object $object
     */
    public function save($object) {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    /**
     * @param object $object
     * @param string $flush
     */
    public function delete($object, $flush = true) {
        $this->entityManager->remove($object);
        if ($flush) {
            $this->entityManager->flush();
        }
    }
}

