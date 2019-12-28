<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Covoiturage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Covoiturage controller.
 *
 */
class CovoiturageController extends Controller
{
    /**
     * Lists all covoiturage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $covoiturages = $em->getRepository('BackOfficeBundle:Covoiturage')->findAll();

        return $this->render('@BackOffice/covoiturage/index.html.twig', array(
            'covoiturages' => $covoiturages,
        ));
    }

    /**
     * Creates a new covoiturage entity.
     *
     */
    public function newAction(Request $request)
    {
        $covoiturage = new Covoiturage();
        $form = $this->createForm('BackOfficeBundle\Form\CovoiturageType', $covoiturage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($covoiturage);
            $em->flush();

            return $this->redirectToRoute('covoiturage_show', array('id' => $covoiturage->getId()));
        }

        return $this->render('@BackOffice/covoiturage/new.html.twig', array(
            'covoiturage' => $covoiturage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a covoiturage entity.
     *
     */
    public function showAction(Covoiturage $covoiturage)
    {
        $deleteForm = $this->createDeleteForm($covoiturage);

        return $this->render('@BackOffice/covoiturage/show.html.twig', array(
            'covoiturage' => $covoiturage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing covoiturage entity.
     *
     */
    public function editAction(Request $request, Covoiturage $covoiturage)
    {
        $deleteForm = $this->createDeleteForm($covoiturage);
        $editForm = $this->createForm('BackOfficeBundle\Form\CovoiturageType', $covoiturage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('covoiturage_show', array('id' => $covoiturage->getId()));
        }

        return $this->render('@BackOffice/covoiturage/edit.html.twig', array(
            'covoiturage' => $covoiturage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a covoiturage entity.
     *
     */
    public function deleteAction(Request $request, Covoiturage $covoiturage)
    {
        $form = $this->createDeleteForm($covoiturage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($covoiturage);
            $em->flush();
        }

        return $this->redirectToRoute('covoiturage_index');
    }

    /**
     * Creates a form to delete a covoiturage entity.
     *
     * @param Covoiturage $covoiturage The covoiturage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Covoiturage $covoiturage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('covoiturage_delete', array('id' => $covoiturage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
