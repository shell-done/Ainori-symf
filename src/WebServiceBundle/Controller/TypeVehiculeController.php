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

use BackOfficeBundle\Entity\TypeVehicule;

/**
 * TypeVehicule controller.
 *
 */
class TypeVehiculeController extends Controller {
    /**
     * Returns all typeVehicule entities
     *
     */
    public function getTypeVehiculesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:TypeVehicule");
        $typevehicules = $repository->getTypeVehicules($hydrated = true);

        if(!$typevehicules) {
            return new Response('', 404);
        }

        return new JsonResponse($typevehicules);
    }

}