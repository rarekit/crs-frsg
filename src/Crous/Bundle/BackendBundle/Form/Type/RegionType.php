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
use Crous\Bundle\BackendBundle\Form\Event\RegionSubscriber;
/**
 * RegionType
 *
 */
class RegionType extends AbstractType {
    
    /**
     * @var ContainerInterface
     */
    protected $_container;

    /**
     * Constructor
     * 
     * @param ContainerInterface $container            
     */
    public function __construct(ContainerInterface $container) {
        $this->_container = $container;
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array ( 
            'label' => 'Region Name', 
            'attr' => array ( 
                'class' => 'form-control', 
                'placeholder' => 'Name',
            ),
            'required' => true 
        ))->add('code', null, array ( 
            'label' => 'Code', 
            'attr' => array ( 
                'class' => 'form-control', 
                'placeholder' => 'Code' 
            ),
            'required' => true 
        ))->add('email', null, array ( 
            'label' => 'Email', 
            'attr' => array ( 
                'class' => 'form-control', 
                'placeholder' => 'Email',
            ) 
        ));
        
        $builder->addEventSubscriber(new RegionSubscriber($this->_container));
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array ( 
            'data_class' => 'Crous\Bundle\BackendBundle\Entity\Region', 
        ));
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName() {
        return 'region';
    }
}
