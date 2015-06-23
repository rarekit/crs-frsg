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
class FormFactory
{

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
     * create a form object by class name
     * 
     * @param string $name
     * @param array  $args
     * @return mixed
     */
    public function create($name, $args = array())
    {
        $form = null;
        if (isset($this->_data[$name])) {
            $data = $this->_data[$name];
            $form = new $data['form']['class']($this->_container, $data['entity_class']);
        }
        return $form;
    }

    /**
     * create a filter type
     * 
     * @param type $name
     * @param type $args
     */
    public function createFilter($name, $args = array())
    {
        $form = null;
        if (isset($this->_data[$name]) && isset($this->_data[$name]['form']['filter_class'])) {
            $data = $this->_data[$name];
            $form = new $data['form']['filter_class']();
        }
        return $form;
    }

}
