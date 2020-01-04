<?php

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
 * Possede controller.
 *
 */
class PossedeController extends Controller {
    /**
     * Returns a voiture entity indicated by the id of the user
     *
     */
    public function getVoitureUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Possede");
        $voiture = $repository->getVoitureUtilisateur($id);

        if(!$voiture) {
            return new Response('', 404);
        }

        return new JsonResponse($voiture);
    }

    public function deleteVoitureUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Possede");
        $voiture = $repository->deleteVoitureUtilisateur($id);

        if(!$voiture) {
            return new Response('', 404);
        }

        return new Response('', 200);
    }

    public function createUtilisateurAction(Request $request) {
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
            $response->setContent(json_encode((string) $form->getErrors(true, false)));
            $response->setStatusCode(400);
        } else {
            $response->setContent($serializer->serialize($utilisateur, 'json'));
            $response->setStatusCode(201);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
     }

}
