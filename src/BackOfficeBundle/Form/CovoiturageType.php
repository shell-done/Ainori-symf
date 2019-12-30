<?php

namespace BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CovoiturageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('co2', null, ["label" => "Co2 économisé"])
                ->add('trajet')
                ->add('typeCovoit', null, ["label" => "Type de covoit."])
                ->add('utilisateur');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackOfficeBundle\Entity\Covoiturage'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backofficebundle_covoiturage';
    }


}
