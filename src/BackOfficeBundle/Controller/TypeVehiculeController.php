<?php

/**
 * Fichier du controller 'TypeVehiculeController' utilisé pour gérer les différentes pages
 * du CRUD relatives à l'entité 'typeVehicule'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\TypeVehicule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller utilisé pour l'affichage des pages relatives du CRUD de la table 'typeVehicule'
 * 
 * Les pages relatives à la table 'typeVehicule' sont :
 *  - index : La liste des différentes entités
 *  - new : Le formulaire pour créer une nouvelle entité
 *  - show : Les détails d'une entité
 *  - edit : Le formulaire pour modifier une entité existante
 */
class TypeVehiculeController extends Controller
{
    /**
     * Affiche la liste des entités 'typeVehicule'
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la liste
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des typeVehicules en base
        $typeVehicules = $em->getRepository('BackOfficeBundle:TypeVehicule')->findAll();

        return $this->render('@BackOffice/typevehicule/index.html.twig', array(
            'typeVehicules' => $typeVehicules,
        ));
    }

    /**
     * Affiche un formulaire pour créer un nouveau 'typeVehicule'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au formulaire
     */
    public function newAction(Request $request)
    {
        $typeVehicule = new Typevehicule();

        // Création du formulaire
        $form = $this->createForm('BackOfficeBundle\Form\TypeVehiculeType', $typeVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegarde l'objet dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeVehicule);
            $em->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('typevehicule_show', array('id' => $typeVehicule->getId()));
        }

        return $this->render('@BackOffice/typevehicule/new.html.twig', array(
            'typeVehicule' => $typeVehicule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'une entité particulière
     *
     * @param TypeVehicule $typeVehicule l'objet typeVehicule demandé (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au détail
     */
    public function showAction(TypeVehicule $typeVehicule)
    {
        $deleteForm = $this->createDeleteForm($typeVehicule);

        return $this->render('@BackOffice/typevehicule/show.html.twig', array(
            'typeVehicule' => $typeVehicule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Affiche un formulaire pour modifier un 'typeVehicule'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param TypeVehicule $typeVehicule l'objet typeVehicule en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function editAction(Request $request, TypeVehicule $typeVehicule)
    {
        $deleteForm = $this->createDeleteForm($typeVehicule);
        
        // Création du formulaire
        $editForm = $this->createForm('BackOfficeBundle\Form\TypeVehiculeType', $typeVehicule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegegarde l'objet dans la base
            $this->getDoctrine()->getManager()->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('typevehicule_show', array('id' => $typeVehicule->getId()));
        }

        return $this->render('@BackOffice/typevehicule/edit.html.twig', array(
            'typeVehicule' => $typeVehicule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Génère un formulaire pour supprimer une 'typeVehicule'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param TypeVehicule $typeVehicule l'objet typeVehicule en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function deleteAction(Request $request, TypeVehicule $typeVehicule)
    {
        $form = $this->createDeleteForm($typeVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeVehicule);
            
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
        return $this->redirectToRoute('typevehicule_index');
    }

    /**
     * Créer un formulaire pour supprimer une entité 'typeVehicule'
     *
     * @param TypeVehicule $typeVehicule l'entité à supprimer
     *
     * @return \Symfony\Component\Form\Form le formulaire de suppression
     */
    private function createDeleteForm(TypeVehicule $typeVehicule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typevehicule_delete', array('id' => $typeVehicule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
