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

use BackOfficeBundle\Entity\TypeTrajet;

/**
 * TypeTrajet controller.
 *
 */
class TypeTrajetController extends Controller {
    /**
     * Returns all typeTrajet entities
     *
     */
    public function getTypeTrajetsAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:TypeTrajet");
        $typetrajets = $repository->getTypeTrajets($hydrated = true);

        if(!$typetrajets) {
            return new Response('', 404);
        }

        return new JsonResponse($typetrajets);
    }

}