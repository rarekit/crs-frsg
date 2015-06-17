<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Manager\Base;

use Crous\Bundle\BackendBundle\Entity\Base\EntityInterface;

/**
 * ManagerInterface
 */
interface ManagerInterface {
    
    public function save(EntityInterface $entity, $isFlush);
    
    public function delete(EntityInterface $entity, $isFlush);
    
    public function getRepository();
}
  
