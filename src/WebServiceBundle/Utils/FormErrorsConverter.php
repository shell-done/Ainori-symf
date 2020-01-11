<?php

namespace WebServiceBundle\Utils;

class FormErrorsConverter {
    private $form;
    
    public function __construct($form) {
        $this->form = $form;
    }

    public function toStringArray($toJson = false) {
        $errors = [];
    
        foreach($this->form->getErrors(true, false) as $error) {
            $msg = "";
            if ($error instanceof FormError)
                $msg = $error->getMessage();
            else
                $msg = $error->getForm()->getName() . " :" . str_replace("ERROR:", "", $error);

            array_push($errors, $msg);
        }

        if($toJson)
            return json_encode($errors);

        return $errors;
    }
}