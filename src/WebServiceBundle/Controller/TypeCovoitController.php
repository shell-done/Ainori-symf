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

use BackOfficeBundle\Entity\TypeCovoit;

/**
 * TypeCovoit controller.
 *
 */
class TypeCovoitController extends Controller {
    /**
     * Returns all typeCovoit entities
     *
     */
    public function getTypeCovoitsAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:TypeCovoit");
        $typecovoits = $repository->getTypeCovoits($hydrated = true);

        if(!$typecovoits) {
            return new Response('', 404);
        }

        return new JsonResponse($typecovoits);
    }

}