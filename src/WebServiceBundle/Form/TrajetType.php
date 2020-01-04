<?php

namespace WebServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetType extends AbstractType {
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('dateDepart')
                ->add('heureDepart')
                ->add('nbPlace')
                ->add('duree')
                ->add('commentaire')
                ->add('nbKm')
                ->add('typeTrajet')
                ->add('villeArrive')
                ->add('villeDepart');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackOfficeBundle\Entity\Trajet',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'webservicebundle_trajet';
    }
}