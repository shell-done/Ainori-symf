<?php

/**
 * Fichier du controller 'Possede' utilisé pour gérer les différentes pages
 * du CRUD relatives à l'entité 'possede'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Possede;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller utilisé pour l'affichage des pages relatives du CRUD de la table 'possede'
 * 
 * Les pages relatives à la table 'possede' sont :
 *  - index : La liste des différentes entités
 *  - new : Le formulaire pour créer une nouvelle entité
 *  - show : Les détails d'une entité
 *  - edit : Le formulaire pour modifier une entité existante
 */
class PossedeController extends Controller
{
    /**
     * Affiche la liste des entités 'possede'
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la liste
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des possedes en base
        $possedes = $em->getRepository('BackOfficeBundle:Possede')->findAll();

        return $this->render('@BackOffice/possede/index.html.twig', array(
            'possedes' => $possedes,
        ));
    }

    /**
     * Affiche un formulaire pour créer un nouveau 'possede'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au formulaire
     */
    public function newAction(Request $request)
    {
        $possede = new Possede();

        // Création du formulaire
        $form = $this->createForm('BackOfficeBundle\Form\PossedeType', $possede);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegarde l'objet dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($possede);
            $em->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('possede_show', array('id' => $possede->getId()));
        }

        return $this->render('@BackOffice/possede/new.html.twig', array(
            'possede' => $possede,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'une entité particulière
     *
     * @param Possede $possede l'objet possede demandé (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au détail
     */
    public function showAction(Possede $possede)
    {
        $deleteForm = $this->createDeleteForm($possede);

        return $this->render('@BackOffice/possede/show.html.twig', array(
            'possede' => $possede,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Affiche un formulaire pour modifier un 'possede'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Possede $possede l'objet possede en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function editAction(Request $request, Possede $possede)
    {
        $deleteForm = $this->createDeleteForm($possede);
        
        // Création du formulaire
        $editForm = $this->createForm('BackOfficeBundle\Form\PossedeType', $possede);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Si le formulaire est soumit et valide, on sauvegegarde l'objet dans la base
            $this->getDoctrine()->getManager()->flush();

            // Puis on redirige vers la page de détails de l'objet créé
            return $this->redirectToRoute('possede_show', array('id' => $possede->getId()));
        }

        return $this->render('@BackOffice/possede/edit.html.twig', array(
            'possede' => $possede,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Génère un formulaire pour supprimer une 'possede'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Possede $possede l'objet possede en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function deleteAction(Request $request, Possede $possede)
    {
        $form = $this->createDeleteForm($possede);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($possede);
            
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
        return $this->redirectToRoute('possede_index');
    }

    /**
     * Créer un formulaire pour supprimer une entité 'possede'
     *
     * @param Possede $possede l'entité à supprimer
     *
     * @return \Symfony\Component\Form\Form le formulaire de suppression
     */
    private function createDeleteForm(Possede $possede)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('possede_delete', array('id' => $possede->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
