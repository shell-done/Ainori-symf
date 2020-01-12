<?php

/**
 * Fichier du controller 'Trajet' utilisé pour gérer les différentes pages
 * du CRUD relatives à l'entité 'trajet'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Trajet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

/**
 * Controller utilisé pour l'affichage des pages relatives du CRUD de la table 'trajet'
 * 
 * Les pages relatives à la table 'trajet' sont :
 *  - index : La liste des différentes entités
 *  - new : Le formulaire pour créer une nouvelle entité
 *  - show : Les détails d'une entité
 *  - edit : Le formulaire pour modifier une entité existante
 */
class TrajetController extends Controller
{
    /**
     * Affiche la liste des entités 'trajet'
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la liste
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des trajets en base
        $trajets = $em->getRepository('BackOfficeBundle:Trajet')->findAll();

        return $this->render('@BackOffice/trajet/index.html.twig', array(
            'trajets' => $trajets,
        ));
    }

    /**
     * Affiche un formulaire pour créer un nouveau 'trajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au formulaire
     */
    public function newAction(Request $request)
    {
        $trajet = new Trajet();

        // Création du formulaire
        $form = $this->createForm('BackOfficeBundle\Form\TrajetType', $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumit et valide, on effectue des vérifications plus complexes
            $hasComplexError = false;

            // On vérifie que le nombre de places pour les passager est inférieur au nombre de places
            // du véhicule.
            if($trajet->getNbPlace() >= $trajet->getPossede()->getNbPlace()) {
                $form->get("nbPlace")->addError(new FormError("Le nombre de places passager doit être inférieure au nombre de place du véhicule"));
                $hasComplexError = true;
            }

            // On vérifie que le moment de départ du trajet ne se situe pas avant l'instant présent
            $now = new \DateTime();
            $trajetDatetime = new \DateTime($trajet->getDateDepart()->format("Y-m-d") . " " . $trajet->getHeureDepart()->format("H:i"));
            if($now > $trajetDatetime) {
                $form->get("dateDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $form->get("heureDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $hasComplexError = true;
            }

            if(!$hasComplexError) {
                // Si aucune erreur complexe n'a été trouvée, on sauvegarde l'objet dans la base
                $em = $this->getDoctrine()->getManager();
                $em->persist($trajet);
                $em->flush();
                
                // Puis on redirige vers la page de détails de l'objet créé
                return $this->redirectToRoute('trajet_show', array('id' => $trajet->getId()));
            }
        }

        return $this->render('@BackOffice/trajet/new.html.twig', array(
            'trajet' => $trajet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'une entité particulière
     *
     * @param Trajet $trajet l'objet trajet demandé (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au détail
     */
    public function showAction(Trajet $trajet)
    {
        $deleteForm = $this->createDeleteForm($trajet);

        return $this->render('@BackOffice/trajet/show.html.twig', array(
            'trajet' => $trajet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Affiche un formulaire pour modifier un 'trajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Trajet $trajet l'objet trajet en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function editAction(Request $request, Trajet $trajet)
    {
        $deleteForm = $this->createDeleteForm($trajet);
        $editForm = $this->createForm('BackOfficeBundle\Form\TrajetType', $trajet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Si le formulaire est soumit et valide, on effectue des vérifications plus complexes
            $hasComplexError = false;

            // On vérifie que le nombre de places pour les passager est inférieur au nombre de places
            // du véhicule.
            if($trajet->getNbPlace() >= $trajet->getPossede()->getNbPlace()) {
                $form->get("nbPlace")->addError(new FormError("Le nombre de places passager doit être inférieure au nombre de place du véhicule"));
                $hasComplexError = true;
            }

            // On vérifie que le moment de départ du trajet ne se situe pas avant l'instant présent
            $now = new \DateTime();
            $trajetDatetime = new \DateTime($trajet->getDateDepart()->format("Y-m-d") . " " . $trajet->getHeureDepart()->format("H:i"));
            if($now > $trajetDatetime) {
                $form->get("dateDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $form->get("heureDepart")->addError(new FormError("Le départ d'un futur trajet ne peut pas être dans le passé"));
                $hasComplexError = true;
            }

            if(!$hasComplexError) {
                // Si aucune erreur complexe n'a été trouvée, on sauvegarde l'objet dans la base
                $this->getDoctrine()->getManager()->flush();

                // Puis on redirige vers la page de détails de l'objet créé
                return $this->redirectToRoute('trajet_show', array('id' => $trajet->getId()));
            }
        }

        return $this->render('@BackOffice/trajet/edit.html.twig', array(
            'trajet' => $trajet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Génère un formulaire pour supprimer une 'trajet'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Trajet $trajet l'objet trajet en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function deleteAction(Request $request, Trajet $trajet)
    {
        $form = $this->createDeleteForm($trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trajet);
            
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
        return $this->redirectToRoute('trajet_index');
    }

    /**
     * Créer un formulaire pour supprimer une entité 'trajet'
     *
     * @param Trajet $trajet l'entité à supprimer
     *
     * @return \Symfony\Component\Form\Form le formulaire de suppression
     */
    private function createDeleteForm(Trajet $trajet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trajet_delete', array('id' => $trajet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
