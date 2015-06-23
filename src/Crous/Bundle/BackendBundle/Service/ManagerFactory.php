<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Crous\Bundle\BackendBundle\Manager\Base\BaseManager;

/**
 * ManagerFactory
 */
class ManagerFactory {

    protected $_container;
    protected $_data;

    /**
     * Constructor
     * 
     * @param ContainerInterface $container
     * @param array $data
     */
    public function __construct(ContainerInterface $container, $data)
    {
        $this->_container = $container;   
        $this->_data = $data;
    }

    /**
     * create an manager by class name
     * 
     * @param string $name
     * @param array  $args
     * @return mixed
     */
    public function create($name)
    {
        $manager = null;
        if (isset($this->_data[$name])) {
            $doctrineMgr = $this->_container->get('doctrine')->getManager();
            if (isset($this->_data[$name]['manager_class'])) {
                $manager = new $this->_data[$name]['manager_class']($doctrineMgr);
            } else {
                $manager = new BaseManager($doctrineMgr, ucfirst($name));
            }
        } 
        
        return $manager;
    }
}
  
