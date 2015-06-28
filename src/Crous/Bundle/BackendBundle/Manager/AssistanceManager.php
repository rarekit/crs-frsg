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
 * AssistanceManager
 */
class AssistanceManager extends BaseManager
{
    protected $_entityName = 'Assistance';
    
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
        return $this->getRepository()->getAssistances($this->_filter($criteria), $order, $limit, $offset);
    }
    
    /**
     * filter
     * 
     * @param array $criteria
     * @return array
     */
    protected function _filter($criteria)
    {
        $acceptedKeys = array('keyword' => null);
        $criterias = array_intersect_key($criteria, $acceptedKeys);
        foreach ($criterias as $key => $value) {
            if (empty($value)) {
                unset($criteria[$key]);
            }
        }
        return $criteria;
    }
    
}
