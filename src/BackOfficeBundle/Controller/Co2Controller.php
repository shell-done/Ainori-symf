<?php

/**
 * Fichier du controller 'Co2' utilisé pour gérer les différentes pages
 * du CRUD relatives à l'entité 'co2'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Co2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller utilisé pour l'affichage des pages relatives du CRUD de la table 'co2'
 * 
 * Les pages relatives à la table 'co2' sont :
 *  - index : La liste des différentes entités
 *  - new : Le formulaire pour créer une nouvelle entité
 *  - show : Les détails d'une entité
 *  - edit : Le formulaire pour modifier une entité existante
 */
class Co2Controller extends Controller
{
    /**
     * Affiche la liste des entités 'co2'
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la liste
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des co2s en base
        $co2s = $em->getRepository('BackOfficeBundle:Co2')->findAll();

        return $this->render('@BackOffice/co2/index.html.twig', array(
            'co2s' => $co2s,
        ));
    }

    /**
     * Affiche un formulaire pour créer un nouveau 'co2'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au formulaire
     */
    public function newAction(Request $request)
    {
        $co2 = new Co2();

        // Création du formulaire
        $form = $this->createForm('BackOfficeBundle\Form\Co2Type', $co2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegarde l'objet dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($co2);
            $em->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('co2_show', array('id' => $co2->getId()));
        }

        return $this->render('@BackOffice/co2/new.html.twig', array(
            'co2' => $co2,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'une entité particulière
     *
     * @param Co2 $co2 l'objet co2 demandé (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au détail
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
     * Affiche un formulaire pour modifier un 'co2'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Co2 $co2 l'objet co2 en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function editAction(Request $request, Co2 $co2)
    {
        $deleteForm = $this->createDeleteForm($co2);

        // Création du formulaire
        $editForm = $this->createForm('BackOfficeBundle\Form\Co2Type', $co2);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegegarde l'objet dans la base
            $this->getDoctrine()->getManager()->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('co2_show', array('id' => $co2->getId()));
        }

        return $this->render('@BackOffice/co2/edit.html.twig', array(
            'co2' => $co2,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Génère un formulaire pour supprimer une 'co2'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Co2 $co2 l'objet co2 en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function deleteAction(Request $request, Co2 $co2)
    {
        $form = $this->createDeleteForm($co2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($co2);
            
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
        return $this->redirectToRoute('co2_index');
    }

    /**
     * Créer un formulaire pour supprimer une entité 'co2'
     *
     * @param Co2 $co2 l'entité à supprimer
     *
     * @return \Symfony\Component\Form\Form le formulaire de suppression
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
