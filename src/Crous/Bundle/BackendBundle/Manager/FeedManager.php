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
 * FeedManager
 */
class FeedManager extends BaseManager
{
    protected $_entityName = 'Feed';
    
    /**
     * find one by
     * 
     * @param array $criteria
     * @return null|Feed
     */
    public function findOneBy($criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }
    
    public function getFeeds()
    {
        return $this->getRepository()->findBy(array());
    }
}
