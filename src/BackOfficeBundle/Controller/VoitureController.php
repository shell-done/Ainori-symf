<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Voiture controller.
 *
 */
class VoitureController extends Controller
{
    /**
     * Lists all voiture entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $voitures = $em->getRepository('BackOfficeBundle:Voiture')->findAll();

        return $this->render('@BackOffice/voiture/index.html.twig', array(
            'voitures' => $voitures,
        ));
    }

    /**
     * Creates a new voiture entity.
     *
     */
    public function newAction(Request $request)
    {
        $voiture = new Voiture();
        $form = $this->createForm('BackOfficeBundle\Form\VoitureType', $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();

            return $this->redirectToRoute('voiture_show', array('id' => $voiture->getId()));
        }

        return $this->render('@BackOffice/voiture/new.html.twig', array(
            'voiture' => $voiture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a voiture entity.
     *
     */
    public function showAction(Voiture $voiture)
    {
        $deleteForm = $this->createDeleteForm($voiture);

        return $this->render('@BackOffice/voiture/show.html.twig', array(
            'voiture' => $voiture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing voiture entity.
     *
     */
    public function editAction(Request $request, Voiture $voiture)
    {
        $deleteForm = $this->createDeleteForm($voiture);
        $editForm = $this->createForm('BackOfficeBundle\Form\VoitureType', $voiture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voiture_show', array('id' => $voiture->getId()));
        }

        return $this->render('@BackOffice/voiture/edit.html.twig', array(
            'voiture' => $voiture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a voiture entity.
     *
     */
    public function deleteAction(Request $request, Voiture $voiture)
    {
        $form = $this->createDeleteForm($voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($voiture);
            
            try {
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                return $this->render('@BackOffice/Default/error.html.twig', [
                    "title" => "Une erreur est survenue lors de la suppression de l'entité",
                    "message" => $e->getMessage()
                ]);
            }
        }

        return $this->redirectToRoute('voiture_index');
    }

    /**
     * Creates a form to delete a voiture entity.
     *
     * @param Voiture $voiture The voiture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Voiture $voiture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('voiture_delete', array('id' => $voiture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
