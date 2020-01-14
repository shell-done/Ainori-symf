<?php

/**
 * Fichier du controller 'CovoiturageController' utilisé pour gérer les différentes pages
 * du CRUD relatives à l'entité 'covoiturage'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Covoiturage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

/**
 * Controller utilisé pour l'affichage des pages relatives du CRUD de la table 'covoiturage'
 * 
 * Les pages relatives à la table 'covoiturage' sont :
 *  - index : La liste des différentes entités
 *  - new : Le formulaire pour créer une nouvelle entité
 *  - show : Les détails d'une entité
 *  - edit : Le formulaire pour modifier une entité existante
 */
class CovoiturageController extends Controller
{
    /**
     * Affiche la liste des entités 'covoiturage'
     *
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la liste
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des covoiturage en base
        $covoiturages = $em->getRepository('BackOfficeBundle:Covoiturage')->findAll();

        return $this->render('@BackOffice/covoiturage/index.html.twig', array(
            'covoiturages' => $covoiturages,
        ));
    }

    /**
     * Affiche un formulaire pour créer un nouveau 'covoiturage'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au formulaire
     */
    public function newAction(Request $request)
    {
        $covoiturage = new Covoiturage();
        
        // Création du formulaire
        $form = $this->createForm('BackOfficeBundle\Form\CovoiturageType', $covoiturage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumit et valide, on effectue des vérifications plus complexes
            $hasComplexError = false;

            $repository = $this->getDoctrine()->getRepository(Covoiturage::class);
            $covoiturages = $repository->getCovoiturageOfTrajet($covoiturage->getTrajet());
            
            // On vérifie qu'il reste au moins une place sur ce trajet
            if(count($covoiturages) >= $covoiturage->getTrajet()->getNbPlace() + 1) {
                $form->get("trajet")->addError(new FormError("Toutes les places pour ce trajet sont déjà prises"));
                $hasComplexError = true;
            }

            // On compte le nombre de covoitureur marqué comme "conducteur" sur ce trajet
            // Normalement ce nombre ne peut pas dépasser 1
            $driverCount = 0;
            foreach($covoiturages as $c) {
                if($c->getTypeCovoit()->getType() == "Conducteur") {
                    $driverCount++;
                }
            }
            
            // Si le nouveau covoitureur est marqué comme "conducteur" mais qu'il y a déjà un
            // conducteur, on affiche une erreur
            if($covoiturage->getTypeCovoit()->getType() == "Conducteur" && $driverCount > 0) {
                $form->get("typeCovoit")->addError(new FormError("Un conducteur a déjà été assigné à ce trajet"));
                $hasComplexError = true;
            }

            // Si le nouveau covoitureur est marqué comme "passager" et qu'il n'est pas associé
            // à une économie de Co2, on affiche une erreur
            if($covoiturage->getTypeCovoit()->getType() == "Passager" && is_null($covoiturage->getCo2())) {
                $form->get("co2")->addError(new FormError("Un passager doit être associé à une économie de Co2"));
                $hasComplexError = true;
            }

            // Si le nouveau covoitureur est marqué comme "conducteur" et qu'il associé
            // à une économie de Co2, on affiche une erreur
            if($covoiturage->getTypeCovoit()->getType() == "Conducteur" && !is_null($covoiturage->getCo2())) {
                $form->get("co2")->addError(new FormError("Un conducteur ne peut pas être associé à une économie de Co2"));
                $hasComplexError = true;
            }

            if(!$hasComplexError) {
                // Si aucune erreur complexe n'a été trouvée, on sauvegarde l'objet dans la base
                $em = $this->getDoctrine()->getManager();
                $em->persist($covoiturage);
                $em->flush();

                // Puis on redirige vers la page de détails de l'objet créé
                return $this->redirectToRoute('covoiturage_show', array('id' => $covoiturage->getId()));
            }
        }

        return $this->render('@BackOffice/covoiturage/new.html.twig', array(
            'covoiturage' => $covoiturage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'une entité particulière
     *
     * @param Covoiturage $covoiturage l'objet covoiturage demandé (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée au détail
     */
    public function showAction(Covoiturage $covoiturage)
    {
        $deleteForm = $this->createDeleteForm($covoiturage);

        return $this->render('@BackOffice/covoiturage/show.html.twig', array(
            'covoiturage' => $covoiturage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Affiche un formulaire pour modifier un 'covoiturage'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Covoiturage $covoiturage l'objet covoiturage en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function editAction(Request $request, Covoiturage $covoiturage)
    {
        $deleteForm = $this->createDeleteForm($covoiturage);
        
        // Création du formulaire
        $editForm = $this->createForm('BackOfficeBundle\Form\CovoiturageType', $covoiturage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Si le formulaire est soumit et valide, on effectue des vérifications plus complexes
            $hasComplexError = false;

            $repository = $this->getDoctrine()->getRepository(Covoiturage::class);
            $covoiturages = $repository->getCovoiturageOfTrajet($covoiturage->getTrajet());
            
            // On enlève des covoiturages associés, le covoiturage qui est en train d'être traité
            foreach($covoiturages as $off => $c) {
                if($c.getId() == $covoiturage.getId())
                    array_splice($covoiturages, $off, 1);
            }

            // On vérifie qu'il reste au moins une place sur ce trajet
            if(count($covoiturages) >= $covoiturage->getTrajet()->getNbPlace() + 1) {
                $form->get("trajet")->addError(new FormError("Toutes les places pour ce trajet sont déjà prises"));
                $hasComplexError = true;
            }

            // On compte le nombre de covoitureur marqué comme "conducteur" sur ce trajet
            // Normalement ce nombre ne peut pas dépasser 1
            $driverCount = 0;
            foreach($covoiturages as $c) {
                if($c->getTypeCovoit()->getType() == "Conducteur") {
                    $driverCount++;
                }
            }
            
            // Si le nouveau covoitureur est marqué comme "conducteur" mais qu'il y a déjà un
            // conducteur, on affiche une erreur
            if($covoiturage->getTypeCovoit()->getType() == "Conducteur" && $driverCount > 0) {
                $form->get("typeCovoit")->addError(new FormError("Un conducteur a déjà été assigné à ce trajet"));
                $hasComplexError = true;
            }

            // Si le nouveau covoitureur est marqué comme "passager" et qu'il n'est pas associé
            // à une économie de Co2, on affiche une erreur
            if($covoiturage->getTypeCovoit()->getType() == "Passager" && is_null($covoiturage->getCo2())) {
                $form->get("co2")->addError(new FormError("Un passager doit être associé à une économie de Co2"));
                $hasComplexError = true;
            }

            // Si le nouveau covoitureur est marqué comme "conducteur" et qu'il associé
            // à une économie de Co2, on affiche une erreur
            if($covoiturage->getTypeCovoit()->getType() == "Conducteur" && !is_null($covoiturage->getCo2())) {
                $form->get("co2")->addError(new FormError("Un conducteur ne peut pas être associé à une économie de Co2"));
                $hasComplexError = true;
            }

            if(!$hasComplexError) {
                // Si aucune erreur complexe n'a été trouvée, on sauvegarde l'objet dans la base
                $this->getDoctrine()->getManager()->flush();

                // Puis on redirige vers la page de détails de l'objet créé
                return $this->redirectToRoute('covoiturage_show', array('id' => $covoiturage->getId()));
            }
        }

        return $this->render('@BackOffice/covoiturage/edit.html.twig', array(
            'covoiturage' => $covoiturage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Génère un formulaire pour supprimer un 'covoiturage'
     *
     * @param Request $request l'objet qui gère la requête HTTP (passé automatiquement par Symfony)
     * @param Covoiturage $covoiturage l'objet covoiturage en question (passé automatiquement par Symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à au détail
     */
    public function deleteAction(Request $request, Covoiturage $covoiturage)
    {
        $form = $this->createDeleteForm($covoiturage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($covoiturage);
            
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
        return $this->redirectToRoute('covoiturage_index');
    }

    /**
     * Créer un formulaire pour supprimer une entité 'covoiturage'
     *
     * @param Covoiturage $covoiturage l'entité à supprimer
     *
     * @return \Symfony\Component\Form\Form le formulaire de suppression
     */
    private function createDeleteForm(Covoiturage $covoiturage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('covoiturage_delete', array('id' => $covoiturage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
