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

use BackOfficeBundle\Entity\Categorie;

/**
 * Categorie controller.
 *
 */
class CategorieController extends Controller {
    /**
     * Returns all categorie entities
     *
     */
    public function getCategoriesAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Categorie");
        $categories = $repository->getCategories($hydrated = true);

        if(!$categories) {
            return new Response('', 404);
        }

        return new JsonResponse($categories);
    }

}