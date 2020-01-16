<?php

/**
 * Fichier du formulaire 'Co2Type'
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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

/**
 * Formulaire utilisé pour la création et l'édition d'entité 'Co2' du CRUD
 */
class TrajetType extends AbstractType
{
    /**
     * Créer le formulaire pour l'entité
     * 
     * @param FormBuilderInterface $builder le constructeur de formulaire
     * @param array $options les options passées au formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new \DateTime();

        // On définit la date de départ minimum à l'instant présent pour empêcher
        // de créer un trajet à une date passée
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
            'data_class' => 'BackOfficeBundle\Entity\Trajet'
        ));
    }

    /**
     * Retourne le préfixe du nom du formulaire.
     * 
     * Ce préfixe est utilisée pour nommé le formulaire et est composé
     * du nom du bundle suivit de celui de la vue
     * Exemple : 'backofficebundle_categorie'
     * 
     * @return string le prefix associé à la vue
     */
    public function getBlockPrefix()
    {
        return 'backofficebundle_trajet';
    }
}
