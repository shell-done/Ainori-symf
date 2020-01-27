<?php

/**
 * Fichier de la classe 'FormErrorConverter'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace WebServiceBundle\Utils;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

/**
 * Classe utilisée pour convertir les erreurs des formulaires Symfony
 * en tableau de string
 */
class FormErrorsConverter {
    // Formulaire à analyser
    private $form;
    
    /**
     * Contruit l'objet
     * 
     * @param Form $form le formulaire à analyser
     */
    public function __construct($form) {
        $this->form = $form;
    }

    /**
     * Retourne les erreurs du formulaire sous forme de tableau de string
     * 
     * @param bool $toJson true pour renvoyé le tableau encodé en json, false pour un tableau php classique
     */
    public function toStringArray($toJson = false) {
        // Liste des erreurs
        $errors = [];
        $tmpFormError = new FormError("");
    
        foreach($this->form->getErrors(true, false) as $error) {
            $msg = "";
            if (get_class($error) == get_class($tmpFormError)) // Si l'entité est de type 'FormError', on récupère directement le message
                $msg = $error->getMessage();
            else { // Sinon, on récupère le formulaire et l'erreur associée
                $msg = ucfirst($error->getForm()->getName()) . " :" . str_replace("ERROR:", "", $error);
            }

            array_push($errors, $msg);
        }

        if($toJson)
            return json_encode($errors);

        return $errors;
    }
}