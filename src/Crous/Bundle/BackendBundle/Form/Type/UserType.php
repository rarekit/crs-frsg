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
use Crous\Bundle\BackendBundle\Form\Event\UserSubscriber;

/**
 * UserType
 *
 */
class UserType extends AbstractType
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
        $builder->add('username', null, array(
            'label' => 'Username',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Username',
                'autocomplete' => 'off'
            ),
            'required' => true
        ))->add('password', 'password', array(
            'label' => 'Password',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Password',
                'autocomplete' => 'off'
            ),
            'required' => true
        ))->add('firstname', null, array(
            'label' => 'Firstname',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Firstname'
            ),
            'required' => true
        ))->add('lastname', null, array(
            'label' => 'Lastname',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Lastname'
            ),
            'required' => true
        ))->add('email', null, array(
            'label' => 'Email',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            )
        ))->add('active', 'checkbox', array ( 
            'label' => 'Status',
            'required' => false, 
            'data' => true,
            'attr' => array ( 
            ) 
        ));

        $builder->addEventSubscriber(new UserSubscriber($this->_container));
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
        return 'user';
    }

}
