<?php

namespace BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class TrajetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new \DateTime();

        $builder->add('dateDepart', DateType::class, [
                    "label" => "Date de départ",
                    "widget" => "single_text", 
                    "attr" => ["min" => $now->format("Y-m-d")]
                ])
                ->add('heureDepart', TimeType::class, [
                    "label" => "Heure de départ",
                    "widget" => "single_text",
                ])
                ->add('nbPlace', null, [
                    "label" => "Nombre de places passager",
                    "attr" => ["min" => "1"]
                ])
                ->add('duree', null, ["label" => "Durée (en heures)"])
                ->add('commentaire')
                ->add('nbKm', null, ["label" => "Distances (en km)"])
                ->add('possede', null, ["label" => "Possède"])
                ->add('typeTrajet', null, ["label" => "Type de trajet"])
                ->add('villeArrivee', null, ["label" => "Ville d'arrivée"])
                ->add('villeDepart', null, ["label" => "Ville de départ"]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackOfficeBundle\Entity\Trajet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backofficebundle_trajet';
    }


}
