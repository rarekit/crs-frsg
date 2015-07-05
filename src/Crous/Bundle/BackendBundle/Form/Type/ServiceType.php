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
use Crous\Bundle\BackendBundle\Form\Event\ServiceSubscriber;

/**
 * ServiceType
 *
 */
class ServiceType extends AbstractType
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
            'empty_value' => "Select a region",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Region',
            ),
            'required' => true
        ))->add('title', null, array(
            'label' => 'Title',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Title'
            ),
            'required' => true
        ))->add('shortDesc', null, array(
            'label' => 'Short Description',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Short Description',
            ),
            'required' => false
        ))->add('lat', null, array(
            'label' => 'Latitude',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Latitude',
            ),
            'required' => false
        ))->add('lon', null, array(
            'label' => 'Longitude',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Longitude',
            ),
            'required' => false
        ))->add('zone', null, array(
            'label' => 'Zone',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Zone',
            ),
            'required' => false
        ))->add('content', 'textarea', array(
            'label' => 'Content',
            'attr' => array(
                'class' => 'form-control tinymce',
                'placeholder' => 'Content',
            ),
            'required' => false
        ))->add('file', 'image', array(
                'label' => 'Image',
                'attr' => array(
                    'placeholder' => 'Image',
                    'delete_route' => 'crous_backend_service_delete_image',
                ),
                'required' => false
        ))
        ;

        $builder->addEventSubscriber(new ServiceSubscriber($this->_container));
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
        return 'service';
    }

}
