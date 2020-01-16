<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use BackOfficeBundle\Entity\Trajet;
use BackOfficeBundle\Entity\Ville;
use BackOfficeBundle\Entity\TypeTrajet;

use WebServiceBundle\Utils\FormErrorsConverter;

/**
 * CovoitConducteur controller.
 *
 */
class CovoitConducteurController extends Controller {
    /**
     * Lists all trajet entities from a user
     *
     */
    public function getCovoitsAsConducteurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Covoiturage");
        $covoiturages = $repository->getCovoitsAsConducteur($id, $hydrated = true);

        if(!$covoiturages) {
            return new Response('', 404);
        }

        return new JsonResponse($covoiturages);
    }

    public function newTrajetAction(Request $request, $id) {
        $erreur = FALSE;

        $trajet = new Trajet();
        $form = $this->createForm('WebServiceBundle\Form\TrajetType', $trajet);
    
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $covoiturage = new Covoiturage();

            $covoiturage->setTrajet($trajet);
            $covoiturage->setTypeCovoit($this->getDoctrine()->getRepository(TypeCovoit::class)->findOneByType("Conducteur"));
            $covoiturage->setUtilisateur($this->getDoctrine()->getRepository(Utilisateur::class)->findById($id));

            $em = $this->getDoctrine()->getManager();
            $em->persist($trajet);
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
            
            $response->setContent($errors);
            $response->setStatusCode(400);
        } else {
            $response->setContent($serializer->serialize($trajet, 'json'));
            $response->setStatusCode(201);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }
    
    public function editTrajetAction(Request $request, $id) {
        $erreur = FALSE;

        $trajetRepo = $this->getDoctrine()->getRepository(Trajet::class);
        $trajet = $trajetRepo->findOneById($id);
        
        if(!$trajet) {
            return new Response('', 404);
        }

        $form = $this->createForm('WebServiceBundle\Form\TrajetType', $trajet);
        
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trajet);
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
            $response->setContent($serializer->serialize($trajet, 'json'));
            $response->setStatusCode(200);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

}