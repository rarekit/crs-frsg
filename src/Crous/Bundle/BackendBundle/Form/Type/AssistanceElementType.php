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
use Crous\Bundle\BackendBundle\Form\Event\AssistanceElementSubscriber;

/**
 * AssistanceElementType
 *
 */
class AssistanceElementType extends AbstractType
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
        $builder->add('subTitle', null, array(
            'label' => 'Sub Title',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Title'
            ),
            'required' => true
        ))->add('content', 'textarea', array(
            'label' => 'Content',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Content',
            ),
            'required' => false
        ))->add('file', 'image', array(
            'label' => 'Image',
            'attr' => array(
                'placeholder' => 'Image',
            ),
            'required' => false
        ))->add('imageShortUrl', 'text', array(
            'label' => 'Image Short Url',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Image Short Url',
                'readonly' => 'readonly'
            ),
            'required' => false
        ))->add('sharingUrl', 'text', array(
            'label' => 'Sharing Url',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Sharing Url',
            ),
            'required' => false
        ))->add('sharingShortUrl', 'text', array(
            'label' => 'Sharing Short Url',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Sharing Short Url',
                'readonly' => 'readonly'
            ),
            'required' => false
        ))
        ;

        $builder->addEventSubscriber(new AssistanceElementSubscriber($this->_container));
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
        return 'assistance_element';
    }

}
