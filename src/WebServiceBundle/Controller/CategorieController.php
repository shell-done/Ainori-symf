<?php

/**
 * Fichier du controller 'CategorieController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'categorie'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Categorie;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'categorie'
 * 
 * Les requêtes sont les suivantes :
 *  - getCategories : GET
 */
class CategorieController extends Controller {
    /**
     * Récupère la liste des entités 'categorie'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return JsonResponse
     */
    public function getCategoriesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Categorie");
        $categories = $repository->getCategories($hydrated = true);

        return new JsonResponse($categories);
    }

}