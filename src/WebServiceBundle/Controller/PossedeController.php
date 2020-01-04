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
        $voiture = $repository->getPossede($id);

        if(!$voiture) {
            return new Response('', 404);
        }

        return new JsonResponse($voiture);
    }

    public function deletePossedeAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Possede");
        $voiture = $repository->deletePossede($id);

        if(!$voiture) {
            return new Response('', 404);
        }

        return new Response('', 200);
    }

    public function createPossedeAction(Request $request) {
        $erreur = FALSE;

        $possede = new Possede();
        $form = $this->createForm('WebServiceBundle\Form\PossedeType', $possede);
        
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
            $response->setContent(json_encode((string) $form->getErrors(true, false)));
            $response->setStatusCode(400);
        } else {
            $response->setContent($serializer->serialize($possede, 'json'));
            $response->setStatusCode(201);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
     }

}
