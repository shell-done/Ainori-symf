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

use BackOfficeBundle\Entity\Ville;

/**
 * Ville controller.
 *
 */
class VilleController extends Controller {
    /**
     * Returns all ville entities
     *
     */
    public function getVillesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Ville");
        $villes = $repository->getVilles();

        if(!$villes) {
            return new Response('', 404);
        }

        return new JsonResponse($villes);
    }

}