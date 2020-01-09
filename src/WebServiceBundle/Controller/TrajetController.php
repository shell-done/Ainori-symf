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

/**
 * Trajet controller.
 *
 */
class TrajetController extends Controller {

    /**
     * Returns a trajet entity indicated by the id
     *
     */
    public function getTrajetAction(Request $request, $id) { 
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajet = $repository->getTrajet($id);

        if(!$trajet) {
            return new Response('', 404);
        }

        return new JsonResponse($trajet);
    }

    /**
     * Lists all trajet entities
     *
     */
    public function getTrajetsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $trajet = new Trajet();
        $trajet->setHeureDepart($request->query->get('heureDepart') ? new \DateTime($request->query->get('heureDepart')) : null);
        $trajet->setDateDepart($request->query->get('dateDepart') ? new \DateTime($request->query->get('dateDepart')) : null);
        $trajet->setVilleDepart($request->query->get('villeDepart') ? $em->getReference("BackOfficeBundle:Ville", $request->query->get('villeDepart')) : null);
        $trajet->setVilleArrivee($request->query->get('villeArrivee') ? $em->getReference("BackOfficeBundle:Ville", $request->query->get('villeArrivee')) : null);
        $trajet->setTypeTrajet($request->query->get('typeTrajet') ? $em->getReference("BackOfficeBundle:TypeTrajet", $request->query->get('typeTrajet')) : null);

        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajets = $repository->getTrajets($trajet);

        return new JsonResponse($trajets);
    }

    public function deleteTrajetAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $trajet = $em->getReference('BackOfficeBundle:Trajet', $id);

        $em->remove($trajet);
        $em->flush();

        return new Response();
    }

    public function newTrajetAction(Request $request) {
        $erreur = FALSE;

        $trajet = new Trajet();
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
            $response->setContent(json_encode((string) $form->getErrors(true, false)));
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
            $response->setContent(json_encode((string) $form->getErrors(true, false)));
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
   