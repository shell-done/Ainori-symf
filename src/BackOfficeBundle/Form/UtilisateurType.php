<?php

namespace BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mail')
                ->add('nom')
                ->add('prenom', null, ["label" => "Prénom"])
                ->add('plainPassword', PasswordType::class, ["label" => "Mot de passe"])
                ->add('telephone', null, [
                    "label" => "Téléphone",
                    "attr" => ["title" => "Ce champ doit être composé d'exactement 10 chiffres"]
                    ])
                ->add('adresse')
                ->add('categorie', null, ["label" => "Catégorie"])
                ->add('ville');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackOfficeBundle\Entity\Utilisateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backofficebundle_utilisateur';
    }


}
