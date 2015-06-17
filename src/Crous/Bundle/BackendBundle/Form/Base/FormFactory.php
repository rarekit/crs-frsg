<?php
/**
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Crous\Bundle\BackendBundle\Form\Base;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * FormFactory
 */
class FormFactory {

    protected $_container;

    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;   
    }

    public function create($name, $args=array())
    {
        switch($name) {
            case 'Region':
                $form = new \Crous\Bundle\BackendBundle\Form\Type\RegionType($this->_container);
                break;
            case 'Splash':
                $form = new \Crous\Bundle\BackendBundle\Form\Type\SplashType($this->_container);
                break;
            default:
                $form = null;
        }

        return $form;
    }
}
  
