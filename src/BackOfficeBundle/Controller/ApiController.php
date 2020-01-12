<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller {

    public function documentationAction() {
        return $this->render('@BackOffice/api/documentation.html.twig');
    }
}
