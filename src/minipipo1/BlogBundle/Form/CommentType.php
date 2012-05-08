<?php

namespace minipipo1\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'minipipo1_blogbundle_commenttype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'minipipo1\BlogBundle\Entity\Comment',
        );
    }
}
