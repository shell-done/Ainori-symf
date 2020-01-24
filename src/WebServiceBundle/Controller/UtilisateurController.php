<?php

/**
 * Fichier du controller 'UtilisateurController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'utilisateur'
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

use BackOfficeBundle\Entity\Utilisateur;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'utilisateur'
 */
class UtilisateurController extends Controller {
    /**
     * Récupère une entité 'utilisateur' définie par son id
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'utilisateur'
     * 
     * @return Response|JsonResponse l'entité demandée si elle existe
     */
    public function getUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Utilisateur");
        $utilisateur = $repository->getUtilisateur($id, $hydrated = true);

        // Si l'entité n'existe pas, on renvoie un code 404 (Not found)
        if(!$utilisateur) {
            $response = new Response('', 404);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            
            return $response;
        }

        $response = new JsonResponse($utilisateur);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * Supprime une entité 'utilisateur' définie par son id
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'utilisateur'
     * 
     * @return Response une réponse vide avec un code HTTP indiquant la réussite ou l'échec de l'opération
     */
    public function deleteUtilisateurAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository("BackOfficeBundle:Utilisateur")->findOneById($id);

        // Si l'entité n'existe pas, on renvoie un code 404 (Not found)
        if(!$utilisateur) {
            $response = new Response('', 404);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            
            return $response;
        }

        $em->remove($utilisateur);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
            // Si l'entité existe mais qu'elle ne peut pas être supprimée car utilisée commme
            // foreign key dans la base, on renvoie un code 409 (Conflict)
            $response = new Response('', 409);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            
            return $response;
        }

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * Créée une entité 'utilisateur'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param UserPasswordEncoderInterface $encoder l'objet qui sert à l'encodage des mots de passe utilisateurs
     * 
     * @return Response l'entité créée
     */
    public function newUtilisateurAction(Request $request, UserPasswordEncoderInterface $encoder) {
        $errors = FALSE;

        // Création d'une entité ainsi que d'un formulaire associé
        $utilisateur = new Utilisateur();
        $form = $this->createForm('WebServiceBundle\Form\UtilisateurType', $utilisateur);

        // Validation du formulaire avec le contenu de la requête POST
        $form->submit($request->request->all());

        if ($form->isValid()) {
            // S'il n'y a pas d'erreur, on hash le mot de passe
            $password = $encoder->encodePassword($utilisateur, $utilisateur->getPlainPassword());
            $utilisateur->setPassword($password);
            
            // Puis on sauvegarde l'entité en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
        }
        else {
            $errors = TRUE;
        }
        
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
    
        $response = new Response();
        
        if($errors) {
            // En cas d'erreur, on renvoie un code 400 avec la liste des erreurs générées
            $errors = (new FormErrorsConverter($form))->toStringArray(true);

            $response->setContent($errors);
            $response->setStatusCode(400);
        } else {
            // Sinon on renvoie l'entité créée au format JSON avec le code 201 (Created)
            $response->setContent($serializer->serialize($utilisateur, 'json'));
            $response->setStatusCode(201);
        }

        // Définition des headers, notamment pour autoriser le cross origin resource sharing (CORS)
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
     * Modifie une entité 'utilisateur'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'utilisateur' à modifier
     * @param UserPasswordEncoderInterface $encoder l'objet qui sert à l'encodage des mots de passe utilisateurs
     * 
     * @return Response l'entité modifiée
     */
    public function editUtilisateurAction(Request $request, $id, UserPasswordEncoderInterface $encoder) {
        $errors = FALSE;

        // Récupération de l'entité à modifier
        $utilisateurRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $utilisateurRepo->findOneById($id);

        // Si celle-ci n'existe pas, on renvoie un code 404
        if(!$utilisateur) {
            return new Response('', 404);
        }

        // Création et validation du formulaire associé à l'entité
        $form = $this->createForm('WebServiceBundle\Form\UtilisateurType', $utilisateur);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            // S'il n'y a pas d'erreur, on hash le mot de passe
            $password = $encoder->encodePassword($utilisateur, $utilisateur->getPlainPassword());
            $utilisateur->setPassword($password);

            // Puis on sauvegarde l'entité en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
        }
        else {
            $errors = TRUE;
        }
        
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        
        if($errors) {
            // En cas d'erreur, on renvoie un code 400 avec la liste des erreurs générées
            $errors = (new FormErrorsConverter($form))->toStringArray(true);

            $response->setContent($errors);
            $response->setStatusCode(400);
        } else {
            // Sinon on renvoie l'entité créée au format JSON
            $response->setContent($serializer->serialize($utilisateur, 'json'));
            $response->setStatusCode(200);
        }

        // Définition des headers, notamment pour autoriser le cross origin resource sharing (CORS)
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

}
