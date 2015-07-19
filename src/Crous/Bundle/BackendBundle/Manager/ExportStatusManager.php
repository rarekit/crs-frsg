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
 * ExportStatusManager
 */
class ExportStatusManager extends BaseManager
{
    protected $_entityName = 'ExportStatus';

    public function getStatus()
    {
        return $this->getRepository()->findBy(array());
    }

    public function getAllSortByType()
    {
        $list = $this->getRepository()->findBy(array());

        $arrByType = array();
        foreach ($list as $item) {
            if ($item->getType() == 'CULTURALEVENT')  {
                $arrByType[$item->getType()][0] = $item;
            } else {
                if (!isset($arrByType[$item->getType()])) {
                    $arrByType[$item->getType()] = array();
                }
                $arrByType[$item->getType()][$item->getRegion()->getId()] = $item;
            }
        }

        return $arrByType;    
    }

    public function getEntry($regionId, $type)
    {
        return $this->getRepository()->findOneBy(array('region'=>$regionId, 'type'=>$type));
    }
}
