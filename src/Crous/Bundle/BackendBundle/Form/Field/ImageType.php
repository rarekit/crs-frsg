<?php

namespace Crous\Bundle\BackendBundle\Form\Field;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefined(array('image_url', 'thumbnail_url'));
        $resolver->setDefaults(array('image_url' => null, 'thumbnail_url'=>null));
    }
  
    /**
     * Pass the image URL to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('image_url', $options)) {
            $parentData = $form->getParent()->getData();
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $imageUrl = $accessor->getValue($parentData, 'image_url');
            } else {
                 $imageUrl = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['image_url'] = $imageUrl;
        }
        
        if (array_key_exists('thumbnail_url', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $imageUrl = $accessor->getValue($parentData, 'thumbnail_url');
            } else {
                 $imageUrl = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['thumbnail_url'] = $imageUrl;
        }
    }

    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'image';
    }
}
