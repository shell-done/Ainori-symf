<?php

/**
 * Fichier du formulaire 'CovoiturageType'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire utilisé pour la création et l'édition d'entité 'Covoiturage' du CRUD
 */
class CovoiturageType extends AbstractType
{
    /**
     * Créer le formulaire pour l'entité
     * 
     * @param FormBuilderInterface $builder le constructeur du formulaire
     * @param array $options les options passées au formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('co2', null, ["label" => "Co2 économisé"])
                ->add('trajet')
                ->add('typeCovoit', null, ["label" => "Type de covoit."])
                ->add('utilisateur');
    }
    
    /**
     * Vérifie la validité des différents champs du formulaire
     * 
     * @param OptionsResolver $resolver l'objet qui vérifie le formulaire
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // La vérification se fait à partir des annotations @Assert dans la classe
        // relative à l'entité
        $resolver->setDefaults(array(
            'data_class' => 'BackOfficeBundle\Entity\Covoiturage'
        ));
    }

    /**
     * Retourne le préfixe du nom du formulaire.
     * 
     * Ce préfixe est utilisé pour nommer le formulaire et est composé
     * du nom du bundle suivi de celui de la vue
     * Exemple : 'backofficebundle_categorie'
     * 
     * @return string le préfixe associé à la vue
     */
    public function getBlockPrefix()
    {
        return 'backofficebundle_covoiturage';
    }
}
