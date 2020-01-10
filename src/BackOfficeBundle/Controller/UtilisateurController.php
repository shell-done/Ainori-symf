<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all utilisateur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('BackOfficeBundle:Utilisateur')->findAll();

        return $this->render('@BackOffice/utilisateur/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Creates a new utilisateur entity.
     *
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm('BackOfficeBundle\Form\UtilisateurType', $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($utilisateur, $utilisateur->getPlainPassword());
            $utilisateur->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('utilisateur_show', array('id' => $utilisateur->getId()));
        }

        return $this->render('@BackOffice/utilisateur/new.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     */
    public function showAction(Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);

        return $this->render('@BackOffice/utilisateur/show.html.twig', array(
            'utilisateur' => $utilisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     */
    public function editAction(Request $request, Utilisateur $utilisateur, UserPasswordEncoderInterface $encoder)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);
        $editForm = $this->createForm('BackOfficeBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $password = $encoder->encodePassword($utilisateur, $utilisateur->getPlainPassword());
            $utilisateur->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_show', array('id' => $utilisateur->getId()));
        }

        return $this->render('@BackOffice/utilisateur/edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a utilisateur entity.
     *
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            
            try {
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                return $this->render('@BackOffice/Default/dberror.html.twig', [
                    "title" => "Une erreur est survenue lors de la suppression de l'entité",
                    "exception" => $e
                ]);
            }
        }

        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * Creates a form to delete a utilisateur entity.
     *
     * @param Utilisateur $utilisateur The utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisateur_delete', array('id' => $utilisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
