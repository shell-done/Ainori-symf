<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BackOfficeBundle\Entity\Utilisateur;
use BackOfficeBundle\Entity\Trajet;
use BackOfficeBundle\Entity\Covoiturage;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $last10Utilisateurs = $repository->getLastUtilisateurs(10);
        $nbUtilisateurs = $repository->countUtilisateurs();

        $repository = $this->getDoctrine()->getRepository(Trajet::class);
        $last10Trajets = $repository->getLastTrajets(10);
        $nbTrajets = $repository->countTrajets();

        $repository = $this->getDoctrine()->getRepository(Covoiturage::class);
        $co2Saved = $repository->getCo2SavedThisMonth();

        return $this->render('@BackOffice/Default/index.html.twig', [
            "last10Utilisateurs" => $last10Utilisateurs,
            "nbUtilisateurs" => $nbUtilisateurs,
            "last10Trajets" => $last10Trajets,
            "nbTrajets" => $nbTrajets,
            "co2Saved" => $co2Saved
            ]);
    }
}
