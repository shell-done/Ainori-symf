<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Trajet;

class CovoiturageController extends Controller
{

    public function getTrajetsUtilisateurAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Covoiturage");
        $trajets = $repository->findTrajetsUtilisateur($id);

        if(!$trajets) {
            return new Response('', 404);
        }

        return new JsonResponse($trajets);
    }
}
   