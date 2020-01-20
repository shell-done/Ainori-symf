<?php

/**
 * Fichier du controller 'CovoiturageController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'covoiturage'
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

use BackOfficeBundle\Entity\Trajet;
use BackOfficeBundle\Entity\Covoiturage;
use BackOfficeBundle\Entity\TypeCovoit;
use BackOfficeBundle\Entity\Co2;

use WebServiceBundle\Utils\FormErrorsConverter;

/**
 * Controller utilisé pour proposer les requêtes relatives à l'API de la table 'covoiturage'
 */
class CovoiturageController extends Controller {
    /**
     * Récupère la liste des entités 'covoiturage' associés à un utilisateur (passagers + conducteur)
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id l'id de l'utilisateur
     * 
     * @return JsonResponse la liste des entités
     */
    public function getCovoituragesUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Covoiturage");
        $covoiturages = $repository->getCovoituragesUtilisateur($id, $hydrated = true);

        return new JsonResponse($covoiturages);
    }

    /**
     * Crée une entité 'covoiturage' associé à un utilisateur et à un trajet (obligatoirement un passager)
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param int $id_user l'id de l'utilisateur
     * @param int $id_trajet l'id du trajet
     * 
     * @return Response l'entité créée
     */
    public function registerToATrajetAction(Request $request, $id_user, $id_trajet) {
        $erreur = FALSE;

        // Création d'une entité ainsi que d'un formulaire associé
        $covoiturage = new Covoiturage();
        $form = $this->createForm('WebServiceBundle\Form\CovoiturageType', $covoiturage);
        
        // Récupérations des attributs de l'entités
        $typeCovoitRepo = $this->getDoctrine()->getRepository(TypeCovoit::class);
        $passager = $typeCovoitRepo->findOneByType("Passager");
        $covoiturage->setTypeCovoit($passager);

        // Validation du formulaire
        $form->submit(["trajet" => $id_trajet, "utilisateur" => $id_user, "typeCovoit" => $passager->getId()]);

        if ($form->isValid()) {
            // S'il n'y a pas d'erreur
            $repository = $this->getDoctrine()->getRepository(Covoiturage::class);
            $covoiturages = $repository->getCovoiturageOfTrajet($covoiturage->getTrajet());
            
            // On vérifie qu'il reste de la place sur ce trajet
            if(count($covoiturages) >= $covoiturage->getTrajet()->getNbPlace() + 1) {
                $form->get("trajet")->addError(new FormError("Toutes les places pour ce trajet sont déjà prises"));
                $erreur = TRUE;
            }
            
            // Création d'une entité Co2 associée à l'économie de ce trajet
            $co2 = new Co2();
            $co2->setActif(true);
            $valCo2 = 0.253 * $covoiturage->getTrajet()->getNbKm();
            $co2->setValCo2($valCo2);
            $covoiturage->setCo2($co2);
            
            if(!$errors) {
                // S'il n'y a aucune erreur, on sauvegarde les entités en base
                $em = $this->getDoctrine()->getManager();
                $em->persist($co2);
                $em->persist($covoiturage);
                $em->flush();
            }
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
            $response->setContent($serializer->serialize($covoiturage, 'json'));
            $response->setStatusCode(201);
        }
    
        // Définition des headers, notamment pour autoriser le cross origin resource sharing (CORS)
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

}
   