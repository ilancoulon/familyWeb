<?php

namespace minipipo1\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    /**
     * @var \minipipo1\UserBundle\Entity\User $current_user
     */
    private $current_user;    
        
    public function __construct(\minipipo1\UserBundle\Entity\User $current_user = NULL) {
            $this->current_user = $current_user;
    }
        
    public function buildForm(FormBuilder $builder, array $options)
    {
        $cu = $this->current_user;
        $builder
            ->add('titre')
            ->add('contenu', 'textarea', array('required' => false)) // Le required à false est juste là pour empêcher que Symfony mette l'attribut required car il cause un bug à cause de TinyMCE
            ->add('auteur', 'entity', array(
                        'empty_value' => "Choisissez l'auteur",
                        'required' => true,
                        'class' => 'minipipo1UserBundle:Membre',
                        'query_builder' => function(\minipipo1\UserBundle\Entity\MembreRepository $er)  use ($options, $cu) {
                                if ($options["data"]->getId())
                                        $user = $options["data"]->getAuteur()->getUser();
                                else
                                        $user = $cu;
                                return $er->createQueryBuilder('m')
                                                ->where('m.user = :user')
                                                ->setParameter('user', $user);
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
