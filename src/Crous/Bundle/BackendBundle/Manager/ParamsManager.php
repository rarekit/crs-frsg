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
 * ParamsManager
 */
class ParamsManager extends BaseManager
{
    protected $_entityName = 'Params';
    
    public function getParams()
    {
        return $this->getRepository()->findBy(array());
    }
}
