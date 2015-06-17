<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Manager;

use Crous\Bundle\BackendBundle\Manager\Base\BaseManager;

/**
 * RegionManager
 */
class RegionManager extends BaseManager
{
    protected $_entityName = 'Region';

    /**
     * get regions by criterias
     * 
     * @param array   $criteria
     * @param array   $order
     * @param integer $limit
     * @param integer $offset
     * @return null|array
     */
    public function getRegions($criteria, $order, $limit = null, $offset = null)
    {
        return $this->getRepository()->getRegions($criteria, $order, $limit, $offset);
    }

    /**
     * get region by code
     * 
     * @param integer $code
     * @return null|Region
     */
    public function getRegionByCode($code)
    {
        return $this->getRepository()->findOneByCode($code);
    }

    /**
     * get total of records by criterias
     * 
     * @param type $criteria
     * @return integer
     */
    public function getTotal($criteria = array())
    {
        return $this->getRepository()->getTotal($criteria);
    }

}
