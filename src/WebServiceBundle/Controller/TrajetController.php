<?php

/**
 * Fichier du controller 'TrajetController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'trajet'
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

use Symfony\Component\Form\FormError;

use WebServiceBundle\Utils\FormErrorsConverter;

use BackOfficeBundle\Entity\Trajet;
use BackOfficeBundle\Entity\Ville;
use BackOfficeBundle\Entity\TypeTrajet;
use BackOfficeBundle\Entity\Covoiturage;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'trajet'
 */
class TrajetController extends Controller {
     /**
     * Renvoie un tableau Json représentants une entité 'trajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id du trajet
     * 
     * @return Response|JsonResponse l'entité demandée si elle existe
     */
    public function getTrajetAction(Request $request, $id) { 
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajet = $repository->getTrajet($id);

        // Si l'entité n'existe pas, on renvoie un code 404 (Not found)
        if(!$trajet) {
            $response = new Response('', 404);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            
            return $response;
        }

        $response = new JsonResponse($trajet);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

     /**
     * Renvoie un tableau Json représentants des entités 'trajet' partielles
     * 
     * Le résumé d'un trajet est constitué de son id, sa ville de départ et d'arrivée,
     * sa date et son heure de départ ainsi que le nombre de place occupée et le nombre de
     * place totale
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return Response|JsonResponse la liste des entités
     */
    public function getTrajetsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $trajet = new Trajet();
        
        // On récupère les paramètres passés dans l'URI
        // Si un paramètre n'a pas la bonne forme, une exception est lancée et une erreur 400 Bad Request est retournée
        try {
            // Pour chaque paramètre, si celui-ci est spécifié alors on set l'attribut de $trajet à la valeur passée, sinon on le met à null
            $trajet->setHeureDepart($request->query->get('heureDepart') ? new \DateTime($request->query->get('heureDepart')) : null);
            $trajet->setDateDepart($request->query->get('dateDepart') ? new \DateTime($request->query->get('dateDepart')) : null);
            $trajet->setVilleDepart($request->query->get('villeDepart') ? $em->getReference("BackOfficeBundle:Ville", $request->query->get('villeDepart')) : null);
            $trajet->setVilleArrivee($request->query->get('villeArrivee') ? $em->getReference("BackOfficeBundle:Ville", $request->query->get('villeArrivee')) : null);
            $trajet->setTypeTrajet($request->query->get('typeTrajet') ? $em->getReference("BackOfficeBundle:TypeTrajet", $request->query->get('typeTrajet')) : null);
        } catch(\Exception $e) {
            $response = new Response('', 400);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            
            return $response;
        }

        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajets = $repository->getTrajets($trajet);

        $response = new JsonResponse($trajets);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
     * Supprime une entité 'trajet' définie par son id
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'trajet'
     * 
     * @return Response une réponse vide avec un code HTTP indiquant la réussite ou l'échec de l'opération
     */
    public function deleteTrajetAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $trajet = $em->getRepository("BackOfficeBundle:Trajet")->findOneById($id);

        // Si l'entité n'existe pas, on renvoie un code 404 (Not found)
        if(!$trajet) {
            $response = new Response('', 404);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            
            return $response;
        }

        $em->remove($trajet);
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
     * Créée une entité 'Trajet' ainsi qu'une entité 'Covoiturage' pour le conducteur
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'utilisateur qui créé le trajet
     * 
     * @return Response les entités créées
     */
    public function newTrajetAction(Request $request, $id) {
        $errors = FALSE;

        // Création d'une entité ainsi que d'un formulaire associé
        $trajet = new Trajet();
        $form = $this->createForm('WebServiceBundle\Form\TrajetType', $trajet);
    
        // Validation du formulaire avec le contenu de la requête POST
        $form->submit($request->request->all());

        if ($form->isValid()) {
            // On vérifie que l'utilisateur existe
            $utilisateur = $this->getDoctrine()->getRepository("BackOfficeBundle:Utilisateur")->findOneById($id);
            if(!$utilisateur)
                return new JsonResponse(json_encode(["Cet utilisateur n'existe pas"]), 404);

            // S'il n'y a pas d'erreur, on créé le covoiturage correspondant à la
            // participation du conducteur au trajet en cours de création
            $covoiturage = new Covoiturage();

            // On définit le trajet, le type de covoit à 'Conducteur' ainsi que l'utilisateur
            $covoiturage->setTrajet($trajet);
            $covoiturage->setTypeCovoit($this->getDoctrine()->getRepository("BackOfficeBundle:TypeCovoit")->findOneByType("Conducteur"));
            $covoiturage->setUtilisateur($utilisateur);

            // On vérifie que le moment de départ du trajet ne se situe pas avant l'instant présent
            $now = new \DateTime();
            $trajetDatetime = new \DateTime($trajet->getDateDepart()->format("Y-m-d") . " " . $trajet->getHeureDepart()->format("H:i"));
            if($now > $trajetDatetime) {
                $form->get("dateDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $form->get("heureDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $errors = TRUE;
            }

            // On vérifie que la date du trajet n'est pas passée
            if($trajet->getNbPlace() > $trajet->getPossede()->getNbPlace()) {
                $form->get("nbPlace")->addError(new FormError("Le nombre de place pour le trajet est supérieur au nombre de place de la voiture"));
                $errors = TRUE;
            }

            if(!$errors) {
                //On sauvegarde les entités en base
                $em = $this->getDoctrine()->getManager();
                $em->persist($trajet);
                $em->persist($covoiturage);
                $em->flush();
            }
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
            $response->setContent($serializer->serialize($trajet, 'json'));
            $response->setStatusCode(201);
        }

        // Définition des headers, notamment pour autoriser le cross origin resource sharing (CORS)
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

    /**
     * Modifie une entité 'trajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'entité 'trajet' à modifier
     * 
     * @return Response l'entité modifiée
     */
    public function editTrajetAction(Request $request, $id) {
        $errors = FALSE;

        // Récupération de l'entité à modifier
        $trajetRepo = $this->getDoctrine()->getRepository(Trajet::class);
        $trajet = $trajetRepo->findOneById($id);
        
        // Si celle-ci n'existe pas, on renvoit un code 404
        if(!$trajet) {
            return new Response('', 404);
        }

        // Création et validation du formulaire associé à l'entité
        $form = $this->createForm('WebServiceBundle\Form\TrajetType', $trajet);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            // S'il n'y a pas d'erreur, on sauvegarde l'entité en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($trajet);
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
            $response->setContent($serializer->serialize($trajet, 'json'));
            $response->setStatusCode(200);
        }

        // Définition des headers, notamment pour autoriser le cross origin resource sharing (CORS)
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }
}
