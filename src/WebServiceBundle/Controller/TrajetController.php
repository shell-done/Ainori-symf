<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TrajetController extends Controller
{
    public function getTrajetAction(Request $request, $id) { 
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajet = $repository->findByIdRest($id);

        if(!$trajet) {
            return new Response('', 404);
        }

        return new JsonResponse($trajet);
    }
}
