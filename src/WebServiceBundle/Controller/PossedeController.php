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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $possede = $repository->getPossede($id, $hydrated = true);

        // Si l'entité n'existe pas, on renvoie un code 404 (Not found)
        if(!$possede) {
            return new Response('', 404);
        }

        return new JsonResponse($possede);
    }

    /**
     * Récupère la liste des entités 'possede' associées à un utilisateurs
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'utilisateur
     * 
     * @return JsonResponse la liste des entités
     */
    public function getPossedesUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Possede");
        $possede = $repository->getPossedesUtilisateur($id, $hydrated = true);

        return new JsonResponse($possede);
    }

    /**
     * Supprime une entité 'possede' définie par son id
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'possede' à supprimer
     * 
     * @return Response une réponse vide avec un code HTTP indiquant la réussite ou l'échec de l'opération
     */
    public function deletePossedeAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $possede = $repository->getPossede($id, $hydrated = true);

        // Si l'entité n'existe pas, on renvoie un code 404 (Not found)
        if(!$possede) {
            return new Response('', 404);
        }

        $em->remove($possede);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
            // Si l'entité existe mais qu'elle ne peut pas être supprimée car utilisée commme
            // foreign key dans la base, on renvoie un code 409 (Conflict)
            return new Response('', 409);
        }

        return new Response();
    }

    /**
     * Crée une entité 'possede'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return Response l'entité créée
     */
    public function newPossedeAction(Request $request) {
        $erreur = FALSE;

        // Création d'une entité ainsi que d'un formulaire associé
        $possede = new Possede();
        $form = $this->createForm('WebServiceBundle\Form\PossedeType', $possede);
        
        // Validation du formulaire avec le contenu de la requête POST
        $form->submit($request->request->all());

        if ($form->isValid()) {
            // S'il n'y a pas d'erreur, on sauvegarde l'entité en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($possede);
            $em->flush();
        }
        else {
            $erreur = TRUE;
        }
        
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
    
        $response = new Response();
        
        if($erreur) {
            // En cas d'erreur, on renvoit un code 400 avec la liste des erreurs générées
            $errors = (new FormErrorsConverter($form))->toStringArray(true);

            $response->setContent($errors);
            $response->setStatusCode(400);
        } else {
            // Sinon on renvoie l'entité créée au format JSON avec le code 201 (Created)
            $response->setContent($serializer->serialize($possede, 'json'));
            $response->setStatusCode(201);
        }

        // Définition des headers, notamment pour autoriser le cross origin resource sharing (CORS)
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
     * Modifie une entité 'possede'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'possede' à modifier
     * 
     * @return Response l'entité modifiée
     */
     public function editPossedeAction(Request $request, $id) {
        $erreur = FALSE;

        // Récupération de l'entité à modifier
        $possedeRepo = $this->getDoctrine()->getRepository(Possede::class);
        $possede = $possedeRepo->findOneById($id);
        
        // Si celle-ci n'existe pas, on renvoit un code 404
        if(!$possede) {
            return new Response('', 404);
        }

        // Création et validation du formulaire associé à l'entité
        $form = $this->createForm('WebServiceBundle\Form\PossedeType', $possede);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            // S'il n'y a pas d'erreur, on sauvegarde l'entité en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($possede);
            $em->flush();
        }
        else {
            $erreur = TRUE;
        }
        
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
    
        $response = new Response();
        
        if($erreur) {
            // En cas d'erreur, on renvoit un code 400 avec la liste des erreurs générées
            $errors = (new FormErrorsConverter($form))->toStringArray(true);

            $response->setContent($errors);
            $response->setStatusCode(400);
        } else {
            // Sinon on renvoie l'entité créée au format JSON
            $response->setContent($serializer->serialize($possede, 'json'));
            $response->setStatusCode(200);
        }

        // Définition des headers, notamment pour autoriser le cross origin resource sharing (CORS)
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
     }

}
