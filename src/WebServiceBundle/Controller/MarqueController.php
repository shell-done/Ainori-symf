<?php

/**
 * Fichier du controller 'MarqueController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'marque'
 * Pour plus d'informations, veuillez consulter la documentation API associée au projet
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Marque;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'marque'
 * représentant les différentes marques de véhicules
 */
class MarqueController extends Controller {
    /**
     * Récupère la liste des entités 'marque'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return JsonResponse la liste des entités
     */
    public function getMarquesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Marque");
        $marques = $repository->getMarques();

        $response = new JsonResponse($marques);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

}