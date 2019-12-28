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
                    "widget" => "single_text", 
                    "attr" => ["min" => $now->format("Y-m-d")]
                ])
                ->add('heureDepart', TimeType::class, [
                    "widget" => "single_text",
                    "attr" => ["min" => $now->format("H:i")]
                ])
                ->add('nbPlace', null, [
                    "attr" => ["min" => "1"]
                ])
                ->add('duree')
                ->add('commentaire')
                ->add('nbKm')
                ->add('possede')
                ->add('typeTrajet')
                ->add('villeArrivee')
                ->add('villeDepart');
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
