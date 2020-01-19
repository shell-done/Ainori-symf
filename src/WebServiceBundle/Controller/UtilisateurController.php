<?php

/**
 * Fichier du controller 'UtilisateurController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'utilisateur'
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

use BackOfficeBundle\Entity\Utilisateur;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'utilisateur'
 * 
 * Les requêtes sont les suivantes :
 *  - getUtilisateur : GET
 *  - deleteUtilisateur : DELETE
 *  - newUtilisateur : POST
 *  - editUtilisateur : POST
 */
class UtilisateurController extends Controller {
    /**
     * Récupère une entité 'utilisateur' définie par son id
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Integer $id l'id de l'entité 'utilisateur'
     * 
     * @return Response|JsonResponse
     */
    public function getUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Utilisateur");
        $utilisateur = $repository->getUtilisateur($id, $hydrated = true);

        if(!$utilisateur) {
            return new Response('', 404);
        }

        return new JsonResponse($utilisateur);
    }

    /**
     * Supprime une entité 'utilisateur' définie par son id
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Integer $id l'id de l'entité 'utilisateur'
     * 
     * @return Response
     */
    public function deleteUtilisateurAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $repository->getUtilisateur($id, $hydrated = true);

        if(!$utilisateur) {
            return new Response('', 404);
        }

        $em->remove($utilisateur);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
            return new Response('', 409);
        }

        return new Response();
    }

    /**
     * Créée une entité 'utilisateur'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return Response
     */
    public function newUtilisateurAction(Request $request) {
        $erreur = FALSE;

        $utilisateur = new Utilisateur();
        $form = $this->createForm('WebServiceBundle\Form\UtilisateurType', $utilisateur);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
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
            $errors = (new FormErrorsConverter($form))->toStringArray(true);

            $response->setContent($errors);
            $response->setStatusCode(400);
        } else {
            $response->setContent($serializer->serialize($utilisateur, 'json'));
            $response->setStatusCode(201);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
     * Modifie une entité 'utilisateur'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Interger $id l'id de l'entité 'utilisateur'
     * 
     * @return Response
     */
    public function editUtilisateurAction(Request $request, $id) {
        $erreur = FALSE;

        $utilisateurRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $utilisateurRepo->findOneById($id);

        if(!$utilisateur) {
            return new Response('', 404);
        }

        $form = $this->createForm('WebServiceBundle\Form\UtilisateurType', $utilisateur);
        
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
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
            $errors = (new FormErrorsConverter($form))->toStringArray(true);

            $response->setContent($errors);
            $response->setStatusCode(400);
        } else {
            $response->setContent($serializer->serialize($utilisateur, 'json'));
            $response->setStatusCode(200);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

}
