<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $trajet = new Trajet();
        $trajet->setHeureDepart($request->query->get('heureDepart'));
        $trajet->setDateDepart($request->query->get('dateDepart'));
        $trajet->setVilleDepart($request->query->get('villeDepart'));
        $trajet->setVilleArrivee($request->query->get('villeArrivee'));
        $trajet->setTypeTrajet($request->query->get('typeTrajet'));

        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajets = $repository->getTrajets($trajet);
    
        if(!$trajets) {
            return new Response('', 404);
        }

        return new JsonResponse($trajets);
    }

    public function createTrajetAction(Request $request) {
        $erreur = FALSE;

        $trajet = new Trajet();
        $form = $this->createForm('WebServiceBundle\Form\TrajetType', $trajet);
        
        $json = $request->getContent();
        if ($decodedJson = json_decode($json, true)) {
            $data = $decodedJson;
        } else {
            $data = $request->request->all();
        }
        $formData = [];
        foreach ($form->all() as $name => $field) {
            if (isset($data[$name])) {
                $formData[$name] = $data[$name];
            }
        }
    
        $form->submit($formData);

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
    
}
   