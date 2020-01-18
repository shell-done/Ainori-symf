<?php

/**
 * Fichier du controller 'CovoiturageController' utilisé pour proposer les différentes requêtes
 * de l'API relatives à l'entité 'covoiturage'
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
 * 
 * Les requêtes sont les suivantes :
 *  - getCovoituragesUtilisateur : GET
 *  - registerToATrajet : POST
 */
class CovoiturageController extends Controller {
    /**
     * Récupère la liste des entités 'covoiturage' associé à un utilisateur (passager + conducteur)
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Integer $id l'id de l'utilisateur
     * 
     * @return Response|JsonResponse 
     */
    public function getCovoituragesUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Covoiturage");
        $covoiturages = $repository->getCovoituragesUtilisateur($id, $hydrated = true);

        if(!$covoiturages) {
            return new Response('', 404);
        }

        return new JsonResponse($covoiturages);
    }

    /**
     * Créée une entité 'covoiturage' associé à un utilisateur et à un trajet
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Integer $id_user l'id de l'utilisateur
     * @param Integer $id_trajet l'id du trajet
     * 
     * @return Response
     */
    public function registerToATrajetAction(Request $request, $id_user, $id_trajet) {
        $erreur = FALSE;

        $covoiturage = new Covoiturage();
        $form = $this->createForm('WebServiceBundle\Form\CovoiturageType', $covoiturage);
        
        $typeCovoitRepo = $this->getDoctrine()->getRepository(TypeCovoit::class);
        $passager = $typeCovoitRepo->findOneByType("Passager");
        $covoiturage->setTypeCovoit($passager);

        $form->submit(["trajet" => $id_trajet, "utilisateur" => $id_user, "typeCovoit" => $passager->getId()]);

        if ($form->isValid()) {
    
            $repository = $this->getDoctrine()->getRepository(Covoiturage::class);
            $covoiturages = $repository->getCovoiturageOfTrajet($covoiturage->getTrajet());
            
            if(count($covoiturages) >= $covoiturage->getTrajet()->getNbPlace() + 1) {
                $form->get("trajet")->addError(new FormError("Toutes les places pour ce trajet sont déjà prises"));
                $erreur = TRUE;
            }
            
            $co2 = new Co2();
            $co2->setActif(true);
            $valCo2 = 0.253 * $covoiturage->getTrajet()->getNbKm();
            $co2->setValCo2($valCo2);
            $covoiturage->setCo2($co2);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($co2);
            $em->persist($covoiturage);
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

            $response->setContent();
            $response->setStatusCode(400);
        } else {
            $response->setContent($serializer->serialize($covoiturage, 'json'));
            $response->setStatusCode(201);
        }
    
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
     }
}
   