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

use BackOfficeBundle\Entity\Utilisateur;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller {
    /**
     * Returns a user entity indicated by the id
     *
     */
    public function getUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Utilisateur");
        $utilisateur = $repository->getUtilisateur($id);

        if(!$utilisateur) {
            return new Response('', 404);
        }

        return new JsonResponse($utilisateur);
    }

    public function deleteUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Utilisateur");
        $utilisateur = $repository->deleteUtilisateur($id);

        if(!$utilisateur) {
            return new Response('', 404);
        }

        return new Response('', 200);
    }

    public function createUtilisateurAction(Request $request) {
        $erreur = FALSE;

        $utilisateur = new Utilisateur();
        $form = $this->createForm('WebServiceBundle\Form\UtilisateurType', $utilisateur);
        
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

     public function modifyUtilisateurAction(Request $request, $id) {
        $erreur = FALSE;

        $utilisateurRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $utilisateurRepo->findOneById($id);

        $form = $this->createForm('WebServiceBundle\Form\UtilisateurType', $utilisateur);
        
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
