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

/**
 * FormFactory
 */
class FormFactory {

    protected $_container;
    protected $_forms;

    /**
     * Constructor
     * 
     * @param ContainerInterface $container
     * @param array $forms
     */
    public function __construct(ContainerInterface $container, $forms)
    {
        $this->_container = $container;   
        $this->_forms = $forms;
    }

    /**
     * create a form object by class name
     * 
     * @param string $name
     * @param array  $args
     * @return mixed
     */
    public function create($name, $args=array())
    {
        $form = null;
        if (isset($this->_forms[$name])) {
            $data = $this->_forms[$name];
            $form = new $data['class']($this->_container, $data['data_class']);
        } 
        return $form;
    }
}
  
