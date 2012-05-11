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
            ->add('auteur', 'entity', array(
                        'empty_value' => "Choisissez l'auteur",
                        'required' => true,
                        'class' => 'minipipo1UserBundle:Membre',
                        'query_builder' => function(\minipipo1\UserBundle\Entity\MembreRepository $er) {
                                return $er->createQueryBuilder('m')
                                                ->where('m.user = :user')
                                                ->setParameter('user', 2); // Ici l'id d'un utilisateur par exemple, ça fonctionne très bien
                        },
            ))
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
