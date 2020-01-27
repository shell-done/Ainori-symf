<?php

/**
 * Fichier du controller 'PossedeController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'possede'
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

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use WebServiceBundle\Utils\FormErrorsConverter;

use BackOfficeBundle\Entity\Possede;


/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'possede'
 */
class PossedeController extends Controller {
    /**
     * Récupère une entité 'possede' définie par son id
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'possede' à récupérer
     *
     * @return Response|JsonResponse l'entité demandée si elle existe
     */
    public function getPossedeAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Possede");
        $possede = $repository->getPossede($id);

        // Si l'entité n'existe pas, on renvoie un code 404 (Not found)
        if(!$possede) {
            $response = new Response('', 404);
            $response->headers->set('Access-Control-Allow-Origin', '*');

            return $response;
        }

        $response = new JsonResponse($possede);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * Récupère la liste des entités 'possede' associées à un utilisateur
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'utilisateur
     *
     * @return JsonResponse la liste des entités
     */
    public function getPossedesUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Possede");
        $possede = $repository->getPossedesUtilisateur($id);

        $response = new JsonResponse($possede);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
    
}
