<?php

namespace BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('codeInsee', null, [
                    "label" => "Code INSEE",
                    "attr" => ["title" => "Ce champ doit être composé d'exactement 5 chiffres"]
                ])
                ->add('ville')
                ->add('codePostal', null, [
                    "attr" => ["title" => "Ce champ doit être composé d'exactement 5 chiffres"]
                ])
                ->add('dep', null, [
                    "label" => "Département",
                    "attr" => ["title" => "Ce champ doit être composé de 1 à 5 chiffres"]
                ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackOfficeBundle\Entity\Ville'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backofficebundle_ville';
    }


}
