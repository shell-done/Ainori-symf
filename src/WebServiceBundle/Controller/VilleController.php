<?php

/**
 * Fichier du controller 'VilleController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'ville'
 * Pour plus d'informations, veuillez consulter la documentation API associée au projet
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Ville;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'ville'
 */
class VilleController extends Controller {
    /**
     * Renvoie un tableau Json représentants des entités 'ville' partielles (id et nom)
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return JsonResponse la liste des entités
     */
    public function getVillesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Ville");
        $villes = $repository->getVilles();
        
        $response = new JsonResponse($villes);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * Renvoie un tableau Json représentants une entité 'ville'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de la ville
     * 
     * @return Response|JsonResponse l'entité demandée si elle existe
     */
    public function getVilleAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Ville");
        $ville = $repository->getVille($id);
        
        if(!$ville)
            return new Response('', 404);

        $response = new JsonResponse($ville);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

}