<?php

/*
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crous\Bundle\BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * SplashType
 *
 */
class SplashType extends AbstractType
{

    /**
     * @var ContainerInterface
     */
    protected $_container;
    protected $_dataClass;

    /**
     * Constructor
     * 
     * @param ContainerInterface $container            
     */
    public function __construct(ContainerInterface $container, $dataClass = null)
    {
        $this->_container = $container;
        $this->_dataClass = $dataClass;
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('region', null, array(
            'label' => 'Region',
            'property' => 'name',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Region',
            ),
            'required' => true
        ))->add('content', null, array(
            'label' => 'Content',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Content'
            ),
            'required' => true
        ));
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::setDefaultOptions()
     */

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->_dataClass,
        ));
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */

    public function getName()
    {
        return 'splash';
    }

}
