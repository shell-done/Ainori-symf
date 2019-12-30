<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Trajet;

class TrajetController extends Controller {
    public function getTrajetAction(Request $request, $id) { 
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajet = $repository->findTrajet($id);

        if(!$trajet) {
            return new Response('', 404);
        }

        return new JsonResponse($trajet);
    }

    public function getTrajetsAction(Request $request) { 
        $trajet = new Trajet();
        $trajet->setHeureDepart($request->query->get('heureDepart'));
        $trajet->setDateDepart($request->query->get('dateDepart'));
        $trajet->setVilleDepart($request->query->get('villeDepart'));
        $trajet->setVilleArrivee($request->query->get('villeArrivee'));
        $trajet->setTypeTrajet($request->query->get('typeTrajet'));

        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajets = $repository->findTrajets($trajet);
    
        if(!$trajets) {
            return new Response('', 404);
        }

        return new JsonResponse($trajets);
    }
    
}
   