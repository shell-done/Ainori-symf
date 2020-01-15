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

use BackOfficeBundle\Entity\Marque;

/**
 * Marque controller.
 *
 */
class MarqueController extends Controller {
    /**
     * Returns all marque entities
     *
     */
    public function getMarquesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Marque");
        $marques = $repository->getMarques($hydrated = true);

        if(!$marques) {
            return new Response('', 404);
        }

        return new JsonResponse($marques);
    }

}