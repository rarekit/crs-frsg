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
 * SplashManager
 */
class SplashManager extends BaseManager
{
    protected $_entityName = 'Splash';

    /**
     * get regions by criterias
     * 
     * @param array   $criteria
     * @param array   $order
     * @param integer $limit
     * @param integer $offset
     * @return null|array
     */
    public function getSplashs($criteria, $order, $limit = null, $offset = null)
    {
        return $this->getRepository()->getSplashs($criteria, $order, $limit, $offset);
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
