<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function debugAction()
    {
        return $this->render('@WebService/Default/index.html.twig');
    }
}
