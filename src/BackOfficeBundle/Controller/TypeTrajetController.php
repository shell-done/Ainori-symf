<?php

/**
 * Fichier du controller 'TypeTrajet' utilisé pour gérer les différentes pages
 * du CRUD relatives à l'entité 'typeTrajet'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\TypeTrajet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller utilisé pour l'affichage des pages relatives du CRUD de la table 'typeTrajet'
 * 
 * Les pages relatives à la table 'typeTrajet' sont :
 *  - index : La liste des différentes entités
 *  - new : Le formulaire pour créer une nouvelle entité
 *  - show : Les détails d'une entité
 *  - edit : Le formulaire pour modifier une entité existante
 */
class TypeTrajetController extends Controller
{
    /**
     * Affiche la liste des entités 'typeTrajet'
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la liste
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des typeTrajets en base
        $typeTrajets = $em->getRepository('BackOfficeBundle:TypeTrajet')->findAll();

        return $this->render('@BackOffice/typetrajet/index.html.twig', array(
            'typeTrajets' => $typeTrajets,
        ));
    }

    /**
     * Affiche un formulaire pour créer un nouveau 'typeTrajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au formulaire
     */
    public function newAction(Request $request)
    {
        $typeTrajet = new Typetrajet();

        // Création du formulaire
        $form = $this->createForm('BackOfficeBundle\Form\TypeTrajetType', $typeTrajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegarde l'objet dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeTrajet);
            $em->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('typetrajet_show', array('id' => $typeTrajet->getId()));
        }

        return $this->render('@BackOffice/typetrajet/new.html.twig', array(
            'typeTrajet' => $typeTrajet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'une entité particulière
     *
     * @param TypeTrajet $typeTrajet l'objet typeTrajet demandé (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au détail
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
     * Affiche un formulaire pour modifier un 'typeTrajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param TypeTrajet $typeTrajet l'objet typeTrajet en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function editAction(Request $request, TypeTrajet $typeTrajet)
    {
        $deleteForm = $this->createDeleteForm($typeTrajet);
        
        // Création du formulaire
        $editForm = $this->createForm('BackOfficeBundle\Form\TypeTrajetType', $typeTrajet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegegarde l'objet dans la base
            $this->getDoctrine()->getManager()->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('typetrajet_show', array('id' => $typeTrajet->getId()));
        }

        return $this->render('@BackOffice/typetrajet/edit.html.twig', array(
            'typeTrajet' => $typeTrajet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Génère un formulaire pour supprimer une 'typeTrajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param TypeTrajet $typeTrajet l'objet typeTrajet en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function deleteAction(Request $request, TypeTrajet $typeTrajet)
    {
        $form = $this->createDeleteForm($typeTrajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeTrajet);
            
            try {
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                // Si l'entité ne peut pas être supprimée, on affiche l'exception

                return $this->render('@BackOffice/Default/error.html.twig', [
                    "title" => "Une erreur est survenue lors de la suppression de l'entité",
                    "message" => $e->getMessage()
                ]);
            }
        }

        // Si l'entité a bien été supprimée, on retourne à la liste
        return $this->redirectToRoute('typetrajet_index');
    }

    /**
     * Créer un formulaire pour supprimer une entité 'typeTrajet'
     *
     * @param TypeTrajet $typeTrajet l'entité à supprimer
     *
     * @return \Symfony\Component\Form\Form le formulaire de suppression
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
