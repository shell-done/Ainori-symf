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
    public function getTypesTrajetAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:TypeTrajet");
        $types_trajet = $repository->getTypesTrajet();

        if(!$types_trajet) {
            return new Response('', 404);
        }

        return new JsonResponse($types_trajet);
    }

}