<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Trajet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

/**
 * Trajet controller.
 *
 */
class TrajetController extends Controller
{
    /**
     * Lists all trajet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trajets = $em->getRepository('BackOfficeBundle:Trajet')->findAll();

        return $this->render('@BackOffice/trajet/index.html.twig', array(
            'trajets' => $trajets,
        ));
    }

    /**
     * Creates a new trajet entity.
     *
     */
    public function newAction(Request $request)
    {
        $trajet = new Trajet();
        $form = $this->createForm('BackOfficeBundle\Form\TrajetType', $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hasComplexError = false;

            if($trajet->getNbPlace() >= $trajet->getPossede()->getNbPlace()) {
                $form->get("nbPlace")->addError(new FormError("Le nombre de places passager doit être inférieure au nombre de place du véhicule"));
                $hasComplexError = true;
            }

            $now = new \DateTime();
            $trajetDatetime = new \DateTime($trajet->getDateDepart()->format("Y-m-d") . " " . $trajet->getHeureDepart()->format("H:i"));
            if($now > $trajetDatetime) {
                $form->get("dateDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $form->get("heureDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $hasComplexError = true;
            }

            if(!$hasComplexError) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($trajet);
                $em->flush();
                
                return $this->redirectToRoute('trajet_show', array('id' => $trajet->getId()));
            }
        }

        return $this->render('@BackOffice/trajet/new.html.twig', array(
            'trajet' => $trajet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a trajet entity.
     *
     */
    public function showAction(Trajet $trajet)
    {
        $deleteForm = $this->createDeleteForm($trajet);

        return $this->render('@BackOffice/trajet/show.html.twig', array(
            'trajet' => $trajet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing trajet entity.
     *
     */
    public function editAction(Request $request, Trajet $trajet)
    {
        $deleteForm = $this->createDeleteForm($trajet);
        $editForm = $this->createForm('BackOfficeBundle\Form\TrajetType', $trajet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $hasComplexError = false;

            if($trajet->getNbPlace() >= $trajet->getPossede()->getNbPlace()) {
                $form->get("nbPlace")->addError(new FormError("Le nombre de places passager doit être inférieure au nombre de place du véhicule"));
                $hasComplexError = true;
            }

            if(!$hasComplexError) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('trajet_show', array('id' => $trajet->getId()));
            }
        }

        return $this->render('@BackOffice/trajet/edit.html.twig', array(
            'trajet' => $trajet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a trajet entity.
     *
     */
    public function deleteAction(Request $request, Trajet $trajet)
    {
        $form = $this->createDeleteForm($trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trajet);
            
            try {
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                return $this->render('@BackOffice/Default/error.html.twig', [
                    "title" => "Une erreur est survenue lors de la suppression de l'entité",
                    "message" => $e->getMessage()
                ]);
            }
        }

        return $this->redirectToRoute('trajet_index');
    }

    /**
     * Creates a form to delete a trajet entity.
     *
     * @param Trajet $trajet The trajet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Trajet $trajet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trajet_delete', array('id' => $trajet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
