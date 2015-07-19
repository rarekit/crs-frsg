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
    protected $_paramsCache = array();
    
    public function getParams()
    {
        if (!empty($this->_paramsCache)) {
            return $this->_paramsCache;
        }
        $list = $this->getRepository()->findBy(array());
        $arrRet = array();
        foreach ($list as $item) {
            $arrRet[$item->getName()] = $item->getValue();
        }

        $this->_paramsCache = $arrRet;
        return $this->_paramsCache;
    }
}
