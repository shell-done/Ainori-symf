<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BackOfficeBundle\Entity\Utilisateur;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $users = $repository->getLastUtilisateurs(10);

        return $this->render('@BackOffice/Default/index.html.twig', ["users" => $users]);
    }
}
