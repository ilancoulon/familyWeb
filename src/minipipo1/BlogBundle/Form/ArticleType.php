<?php

namespace minipipo1\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('contenu', 'textarea', array('required' => true))
        ;
    }

    public function getName()
    {
        return 'minipipo1_blogbundle_articletype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'minipipo1\BlogBundle\Entity\Article',
        );
    }
}
