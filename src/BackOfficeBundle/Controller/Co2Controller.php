<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Co2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Co2 controller.
 *
 */
class Co2Controller extends Controller
{
    /**
     * Lists all co2 entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $co2s = $em->getRepository('BackOfficeBundle:Co2')->findAll();

        return $this->render('@BackOffice/co2/index.html.twig', array(
            'co2s' => $co2s,
        ));
    }

    /**
     * Creates a new co2 entity.
     *
     */
    public function newAction(Request $request)
    {
        $co2 = new Co2();
        $form = $this->createForm('BackOfficeBundle\Form\Co2Type', $co2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($co2);
            $em->flush();

            return $this->redirectToRoute('co2_show', array('id' => $co2->getId()));
        }

        return $this->render('@BackOffice/co2/new.html.twig', array(
            'co2' => $co2,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a co2 entity.
     *
     */
    public function showAction(Co2 $co2)
    {
        $deleteForm = $this->createDeleteForm($co2);

        return $this->render('@BackOffice/co2/show.html.twig', array(
            'co2' => $co2,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing co2 entity.
     *
     */
    public function editAction(Request $request, Co2 $co2)
    {
        $deleteForm = $this->createDeleteForm($co2);
        $editForm = $this->createForm('BackOfficeBundle\Form\Co2Type', $co2);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('co2_edit', array('id' => $co2->getId()));
        }

        return $this->render('@BackOffice/co2/edit.html.twig', array(
            'co2' => $co2,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a co2 entity.
     *
     */
    public function deleteAction(Request $request, Co2 $co2)
    {
        $form = $this->createDeleteForm($co2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($co2);
            $em->flush();
        }

        return $this->redirectToRoute('co2_index');
    }

    /**
     * Creates a form to delete a co2 entity.
     *
     * @param Co2 $co2 The co2 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Co2 $co2)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('co2_delete', array('id' => $co2->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
