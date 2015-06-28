<?php

namespace Crous\Bundle\BackendBundle\Repository;


/**
 * AssistanceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AssistanceRepository extends BaseRepository
{
    /**
     * Get objects
     * 
     * @param array   $criteria
     * @param array   $order
     * @param integer $limit
     * @param integer $offset
     */
    public function getAssistances($criteria, $order = array(), $limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('o');
        if (!empty($criteria)) {
            $where = $qb->expr()->andX();
            foreach ($criteria as $key => $value) {
                if ('keyword' === $key) {
                    $where->add($qb->expr()->orX(
                        $qb->expr()->like('o.title', ":$key"),
                        $qb->expr()->like('o.shortDesc', ":$key")
                    ));
                    $qb->setParameter($key, "%$value%");
                } else {
                    $where->add($qb->expr()->eq("o.{$key}", ":$key"));
                    $qb->setParameter($key, $value);
                }
            }
            $qb->add('where', $where);
        }
        //Ordering
        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $qb->addOrderBy("o.$key", $value);
            }
        }
        //Limit
        $qb->setFirstResult($offset)->setMaxResults($limit);
        
        return $qb->getQuery()->getResult();
    }

    /**
     * get total of records by criterias
     * 
     * @param type $criteria
     * @return type
     */
    public function countBy($criteria = array())
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('count(o.id)');
        if (!empty($criteria)) {
             $where = $qb->expr()->andX();
            foreach ($criteria as $key => $value) {
                if ('keyword' === $key) {
                    $where->add($qb->expr()->orX(
                        $qb->expr()->like('o.title', ":$key"),
                        $qb->expr()->like('o.shortDesc', ":$key")
                    ));
                    $qb->setParameter($key, "%$value%");
                } else {
                    $where->add($qb->expr()->eq("o.{$key}", ":$key"));
                    $qb->setParameter($key, $value);
                }
            }
            $qb->add('where', $where);
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
}
