<?php

namespace WebServiceBundle\Utils;

use Symfony\Component\Form\FormError;

class FormErrorsConverter {
    private $form;
    
    public function __construct($form) {
        $this->form = $form;
    }

    public function toStringArray($toJson = false) {
        $errors = [];
        $tmpFormError = new FormError("");
    
        foreach($this->form->getErrors(true, false) as $error) {
            $msg = "";
            if (get_class($error) == get_class($tmpFormError))
                $msg = $error->getMessage();
            else {
                $msg = ucfirst($error->getForm()->getName()) . " :" . str_replace("ERROR:", "", $error);
            }

            array_push($errors, $msg);
        }

        if($toJson)
            return json_encode($errors);

        return $errors;
    }
}