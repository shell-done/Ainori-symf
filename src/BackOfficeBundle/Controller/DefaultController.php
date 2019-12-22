<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BackOfficeBundle\Entity\Utilisateur;
use BackOfficeBundle\Entity\Trajet;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $users = $repository->getLastUtilisateurs(10);

        $repository = $this->getDoctrine()->getRepository(Trajet::class);
        $trajets = $repository->getLastTrajets(10);

        return $this->render('@BackOffice/Default/index.html.twig', ["users" => $users]);
    }
}
