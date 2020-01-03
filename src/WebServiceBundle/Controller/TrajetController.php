<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Trajet;

/**
 * Trajet controller.
 *
 */
class TrajetController extends Controller {

    /**
     * Returns a trajet entity indicated by the id
     *
     */
    public function getTrajetAction(Request $request, $id) { 
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajet = $repository->getTrajet($id);

        if(!$trajet) {
            return new Response('', 404);
        }

        return new JsonResponse($trajet);
    }

    /**
     * Lists all trajet entities
     *
     */
    public function getTrajetsAction(Request $request) { 
        $trajet = new Trajet();
        $trajet->setHeureDepart($request->query->get('heureDepart'));
        $trajet->setDateDepart($request->query->get('dateDepart'));
        $trajet->setVilleDepart($request->query->get('villeDepart'));
        $trajet->setVilleArrivee($request->query->get('villeArrivee'));
        $trajet->setTypeTrajet($request->query->get('typeTrajet'));

        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajets = $repository->getTrajets($trajet);
    
        if(!$trajets) {
            return new Response('', 404);
        }

        return new JsonResponse($trajets);
    }
    
}
   