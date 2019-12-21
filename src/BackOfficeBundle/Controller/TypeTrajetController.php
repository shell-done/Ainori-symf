<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\TypeTrajet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Typetrajet controller.
 *
 */
class TypeTrajetController extends Controller
{
    /**
     * Lists all typeTrajet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeTrajets = $em->getRepository('BackOfficeBundle:TypeTrajet')->findAll();

        return $this->render('@BackOffice/typetrajet/index.html.twig', array(
            'typeTrajets' => $typeTrajets,
        ));
    }

    /**
     * Creates a new typeTrajet entity.
     *
     */
    public function newAction(Request $request)
    {
        $typeTrajet = new Typetrajet();
        $form = $this->createForm('BackOfficeBundle\Form\TypeTrajetType', $typeTrajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeTrajet);
            $em->flush();

            return $this->redirectToRoute('typetrajet_show', array('id' => $typeTrajet->getId()));
        }

        return $this->render('@BackOffice/typetrajet/new.html.twig', array(
            'typeTrajet' => $typeTrajet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeTrajet entity.
     *
     */
    public function showAction(TypeTrajet $typeTrajet)
    {
        $deleteForm = $this->createDeleteForm($typeTrajet);

        return $this->render('@BackOffice/typetrajet/show.html.twig', array(
            'typeTrajet' => $typeTrajet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeTrajet entity.
     *
     */
    public function editAction(Request $request, TypeTrajet $typeTrajet)
    {
        $deleteForm = $this->createDeleteForm($typeTrajet);
        $editForm = $this->createForm('BackOfficeBundle\Form\TypeTrajetType', $typeTrajet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typetrajet_edit', array('id' => $typeTrajet->getId()));
        }

        return $this->render('@BackOffice/typetrajet/edit.html.twig', array(
            'typeTrajet' => $typeTrajet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeTrajet entity.
     *
     */
    public function deleteAction(Request $request, TypeTrajet $typeTrajet)
    {
        $form = $this->createDeleteForm($typeTrajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeTrajet);
            $em->flush();
        }

        return $this->redirectToRoute('typetrajet_index');
    }

    /**
     * Creates a form to delete a typeTrajet entity.
     *
     * @param TypeTrajet $typeTrajet The typeTrajet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeTrajet $typeTrajet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typetrajet_delete', array('id' => $typeTrajet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
