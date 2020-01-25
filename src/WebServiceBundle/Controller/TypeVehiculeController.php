<?php

/**
 * Fichier du controller 'TypeTrajetController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'typeTrajet'
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

use BackOfficeBundle\Entity\TypeVehicule;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'typeVehicule'
 */
class TypeVehiculeController extends Controller {
    /**
     * Récupère la liste des entités 'typeVehicule'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return JsonResponse la liste des entités
     */
    public function getTypeVehiculesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:TypeVehicule");
        $typevehicules = $repository->getTypeVehicules($hydrated = true);

        $response = new JsonResponse($typevehicules);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

}