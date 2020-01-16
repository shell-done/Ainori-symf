<?php

namespace WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use BackOfficeBundle\Entity\Trajet;
use BackOfficeBundle\Entity\Ville;
use BackOfficeBundle\Entity\TypeTrajet;

use WebServiceBundle\Utils\FormErrorsConverter;

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
        $trajet = $repository->getTrajet($id, $hydrated = true);

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
        $em = $this->getDoctrine()->getManager();

        $trajet = new Trajet();
        
        // Si un paramètre n'a pas la bonne forme, une exception est lancée et une erreur 400 Bad request est retournée
        try {
            $trajet->setHeureDepart($request->query->get('heureDepart') ? new \DateTime($request->query->get('heureDepart')) : null);
            $trajet->setDateDepart($request->query->get('dateDepart') ? new \DateTime($request->query->get('dateDepart')) : null);
            $trajet->setVilleDepart($request->query->get('villeDepart') ? $em->getReference("BackOfficeBundle:Ville", $request->query->get('villeDepart')) : null);
            $trajet->setVilleArrivee($request->query->get('villeArrivee') ? $em->getReference("BackOfficeBundle:Ville", $request->query->get('villeArrivee')) : null);
            $trajet->setTypeTrajet($request->query->get('typeTrajet') ? $em->getReference("BackOfficeBundle:TypeTrajet", $request->query->get('typeTrajet')) : null);
        } catch(\Exception $e) {
            return new Response('', 400);
        }

        $repository = $this->getDoctrine()->getRepository("BackOfficeBundle:Trajet");
        $trajets = $repository->getTrajets($trajet, $hydrated = true);

        return new JsonResponse($trajets);
    }

    public function deleteTrajetAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $trajet = $repository->getTrajet($id);

        if(!$trajet) {
            return new Response('', 404);
        }

        $em->remove($trajet);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
            return new Response('', 409);
        }

        return new Response();
    }

}
   