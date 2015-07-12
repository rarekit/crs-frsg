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
 * PushType
 *
 */
class PushType extends AbstractType
{

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('region', 'entity', array(
            'label' => 'Region',
            'class' => 'CrousBackendBundle:Region',
            'property' => 'name',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Region',
            ),
            'required' => true
        ))->add('title', 'text', array(
            'label' => 'Title',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Title'
            ),
            'required' => true
        ))->add('message', 'textarea', array(
            'label' => 'Message',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Message'
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
        ));
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */

    public function getName()
    {
        return 'push';
    }

}
