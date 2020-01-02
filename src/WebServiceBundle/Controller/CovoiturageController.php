<?php

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

class CovoiturageController extends Controller {

    public function getTrajetsUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Covoiturage");
        $trajets = $repository->findTrajetsUtilisateur($id);

        if(!$trajets) {
            return new Response('', 404);
        }

        return new JsonResponse($trajets);
    }

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
        
        $encoders = [ new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
    
        $response = new Response();
        
        if($erreur) {
            $response->setContent(json_encode((string) $form->getErrors(true, false)));
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
   