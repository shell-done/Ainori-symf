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
    public function getPossedeAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Possede");
        $possede = $repository->getPossede($id, $hydrated = true);

        if(!$possede) {
            return new Response('', 404);
        }

        return new JsonResponse($possede);
    }

    public function deletePossedeAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $possede = $repository->getPossede($id, $hydrated = true);

        if(!$possede) {
            return new Response('', 404);
        }

        $em->remove($possede);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
            return new Response('', 409);
        }

        return new Response();
    }

    public function newPossedeAction(Request $request) {
        $erreur = FALSE;

        $possede = new Possede();
        $form = $this->createForm('WebServiceBundle\Form\PossedeType', $possede);
        
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($possede);
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
            $response->setContent($serializer->serialize($possede, 'json'));
            $response->setStatusCode(201);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
     }

     public function editPossedeAction(Request $request, $id) {
        $erreur = FALSE;

        $possedeRepo = $this->getDoctrine()->getRepository(Possede::class);
        $possede = $possedeRepo->findOneById($id);
        
        if(!$possede) {
            return new Response('', 404);
        }

        $form = $this->createForm('WebServiceBundle\Form\PossedeType', $possede);
        
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($possede);
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
            $response->setContent($serializer->serialize($possede, 'json'));
            $response->setStatusCode(200);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
     }

}
