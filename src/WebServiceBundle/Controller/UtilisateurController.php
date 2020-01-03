<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use BackOfficeBundle\Entity\Utilisateur;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller {
    /**
     * Returns a user entity indicated by the id
     *
     */
    public function getUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Utilisateur");
        $utilisateur = $repository->getUtilisateur($id);

        if(!$utilisateur) {
            return new Response('', 404);
        }

        return new JsonResponse($utilisateur);
    }

    public function deleteUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Utilisateur");
        $utilisateur = $repository->deleteUtilisateur($id);

        if(!$utilisateur) {
            return new Response('', 404);
        }

        return new Response('', 200);
    }

}
