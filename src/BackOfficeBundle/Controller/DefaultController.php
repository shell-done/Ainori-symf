<?php

/**
 * Fichier du controller 'DefaultController' utilisé pour gérer la page principale
 * du back office
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BackOfficeBundle\Entity\Utilisateur;
use BackOfficeBundle\Entity\Trajet;
use BackOfficeBundle\Entity\Covoiturage;

/**
 * Controller utilisé pour l'affichage de la page principale du
 * back office
 */
class DefaultController extends Controller
{
    /**
     * Affiche la page principale du back office
     * 
     * Cette page contient les informations suivantes :
     *  - La moyenne de Co2 économisé par mois sur l'année courante
     *  - Le nombre d'utilisateur inscrits
     *  - Le nombre de trajets proposés
     *  - Les 10 derniers utilisateurs inscrits
     *  - Les 10 derniers trajets proposés
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la page
     */
    public function indexAction()
    {
        // Récupérations des différentes informations
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $last10Utilisateurs = $repository->getLastUtilisateurs(10);
        $nbUtilisateurs = $repository->countUtilisateurs();

        $repository = $this->getDoctrine()->getRepository(Trajet::class);
        $last10Trajets = $repository->getLastTrajets(10);
        $nbTrajets = $repository->countTrajets();

        $repository = $this->getDoctrine()->getRepository(Covoiturage::class);
        $co2SavedByMonth = $repository->getCo2EconomyByMonth();
        $co2SavedAvg = number_format(array_sum($co2SavedByMonth)/12, 1);

        // Affichage de la page avec ces informations
        return $this->render('@BackOffice/Default/index.html.twig', [
            "last10Utilisateurs" => $last10Utilisateurs,
            "nbUtilisateurs" => $nbUtilisateurs,
            "last10Trajets" => $last10Trajets,
            "nbTrajets" => $nbTrajets,
            "co2SavedAvg" => $co2SavedAvg,
            "co2SavedByMonth" => $co2SavedByMonth
        ]);
    }
}
