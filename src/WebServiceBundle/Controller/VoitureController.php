<?php

/**
 * Fichier du controller 'VoitureController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'voiture'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Voiture;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'voiture'
 * 
 * Les requêtes sont les suivantes :
 *  - getVoitures : GET
 */
class VoitureController extends Controller {
    /**
     * Récupère la liste des entités 'voiture'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return JsonResponse
     */
    public function getVoituresAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Voiture");
        $voitures = $repository->getVoitures($hydrated = true);

        return new JsonResponse($voitures);
    }

}