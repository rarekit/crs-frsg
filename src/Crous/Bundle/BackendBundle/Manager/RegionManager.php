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
     * get region by code
     * 
     * @param integer $code
     * @return null|Region
     */
    public function getRegionByCode($code)
    {
        return $this->getRepository()->findOneByCode($code);
    }
    
    public function getRegions()
    {
        return $this->getRepository()->findBy(array(), array('name'=>'DESC'), 1000, 0);
    }
}
