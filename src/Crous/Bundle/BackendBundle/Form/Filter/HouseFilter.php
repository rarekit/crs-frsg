<?php

/*
 * This file is part of the Crous package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crous\Bundle\BackendBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * HouseFilter
 *
 */
class HouseFilter extends AbstractType
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
            'empty_value' => "All",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Region',
            ),
            'required' => false
        ))->add('keyword', 'text', array(
            'label' => 'Keyword',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Keyword'
            ),
            'required' => false
        ));
    }
    
    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\FormTypeInterface::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }
    
    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'house';
    }

}
