<?php

/**
 * Fichier du controller 'TypeCovoitController' utilisé pour gérer les différentes pages
 * du CRUD relatives à l'entité 'typeCovoit'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\TypeCovoit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller utilisé pour l'affichage des pages relatives du CRUD de la table 'typeCovoit'
 * 
 * Les pages relatives à la table 'typeCovoit' sont :
 *  - index : La liste des différentes entités
 *  - new : Le formulaire pour créer une nouvelle entité
 *  - show : Les détails d'une entité
 *  - edit : Le formulaire pour modifier une entité existante
 */
class TypeCovoitController extends Controller
{
    /**
     * Affiche la liste des entités 'typeCovoit'
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la liste
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des typeCovoits en base
        $typeCovoits = $em->getRepository('BackOfficeBundle:TypeCovoit')->findAll();

        return $this->render('@BackOffice/typecovoit/index.html.twig', array(
            'typeCovoits' => $typeCovoits,
        ));
    }

    /**
     * Affiche un formulaire pour créer un nouveau 'typeCovoit'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au formulaire
     */
    public function newAction(Request $request)
    {
        $typeCovoit = new Typecovoit();

        // Création du formulaire
        $form = $this->createForm('BackOfficeBundle\Form\TypeCovoitType', $typeCovoit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegarde l'objet dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCovoit);
            $em->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('typecovoit_show', array('id' => $typeCovoit->getId()));
        }

        return $this->render('@BackOffice/typecovoit/new.html.twig', array(
            'typeCovoit' => $typeCovoit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'une entité particulière
     *
     * @param TypeCovoit $typeCovoit l'objet typeCovoit demandé (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au détail
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
     * Affiche un formulaire pour modifier un 'typeCovoit'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param TypeCovoit $typeCovoit l'objet typeCovoit en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function editAction(Request $request, TypeCovoit $typeCovoit)
    {
        $deleteForm = $this->createDeleteForm($typeCovoit);

        // Création du formulaire
        $editForm = $this->createForm('BackOfficeBundle\Form\TypeCovoitType', $typeCovoit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegegarde l'objet dans la base
            $this->getDoctrine()->getManager()->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('typecovoit_show', array('id' => $typeCovoit->getId()));
        }

        return $this->render('@BackOffice/typecovoit/edit.html.twig', array(
            'typeCovoit' => $typeCovoit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Génère un formulaire pour supprimer une 'typeCovoit'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param TypeCovoit $typeCovoit l'objet typeCovoit en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
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
                // Si l'entité ne peut pas être supprimée, on affiche l'exception

                return $this->render('@BackOffice/Default/error.html.twig', [
                    "title" => "Une erreur est survenue lors de la suppression de l'entité",
                    "message" => $e->getMessage()
                ]);
            }
        }

        // Si l'entité a bien été supprimée, on retourne à la liste
        return $this->redirectToRoute('typecovoit_index');
    }

    /**
     * Créer un formulaire pour supprimer une entité 'typeCovoit'
     *
     * @param TypeCovoit $typeCovoit l'entité à supprimer
     *
     * @return \Symfony\Component\Form\Form le formulaire de suppression
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
