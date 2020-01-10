<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\TypeCovoit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Typecovoit controller.
 *
 */
class TypeCovoitController extends Controller
{
    /**
     * Lists all typeCovoit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeCovoits = $em->getRepository('BackOfficeBundle:TypeCovoit')->findAll();

        return $this->render('@BackOffice/typecovoit/index.html.twig', array(
            'typeCovoits' => $typeCovoits,
        ));
    }

    /**
     * Creates a new typeCovoit entity.
     *
     */
    public function newAction(Request $request)
    {
        $typeCovoit = new Typecovoit();
        $form = $this->createForm('BackOfficeBundle\Form\TypeCovoitType', $typeCovoit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCovoit);
            $em->flush();

            return $this->redirectToRoute('typecovoit_show', array('id' => $typeCovoit->getId()));
        }

        return $this->render('@BackOffice/typecovoit/new.html.twig', array(
            'typeCovoit' => $typeCovoit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeCovoit entity.
     *
     */
    public function showAction(TypeCovoit $typeCovoit)
    {
        $deleteForm = $this->createDeleteForm($typeCovoit);

        return $this->render('@BackOffice/typecovoit/show.html.twig', array(
            'typeCovoit' => $typeCovoit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeCovoit entity.
     *
     */
    public function editAction(Request $request, TypeCovoit $typeCovoit)
    {
        $deleteForm = $this->createDeleteForm($typeCovoit);
        $editForm = $this->createForm('BackOfficeBundle\Form\TypeCovoitType', $typeCovoit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typecovoit_show', array('id' => $typeCovoit->getId()));
        }

        return $this->render('@BackOffice/typecovoit/edit.html.twig', array(
            'typeCovoit' => $typeCovoit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeCovoit entity.
     *
     */
    public function deleteAction(Request $request, TypeCovoit $typeCovoit)
    {
        $form = $this->createDeleteForm($typeCovoit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeCovoit);
            
            try {
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                return $this->render('@BackOffice/Default/dberror.html.twig', [
                    "title" => "Une erreur est survenue lors de la suppression de l'entité",
                    "exception" => $e
                ]);
            }
        }

        return $this->redirectToRoute('typecovoit_index');
    }

    /**
     * Creates a form to delete a typeCovoit entity.
     *
     * @param TypeCovoit $typeCovoit The typeCovoit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeCovoit $typeCovoit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typecovoit_delete', array('id' => $typeCovoit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
