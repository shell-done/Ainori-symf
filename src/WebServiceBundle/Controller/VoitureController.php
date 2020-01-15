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

use BackOfficeBundle\Entity\Voiture;

/**
 * Voiture controller.
 *
 */
class VoitureController extends Controller {
    /**
     * Returns all voiture entities
     *
     */
    public function getVoituresAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Voiture");
        $voitures = $repository->getVoitures($hydrated = true);

        if(!$voitures) {
            return new Response('', 404);
        }

        return new JsonResponse($voitures);
    }

}