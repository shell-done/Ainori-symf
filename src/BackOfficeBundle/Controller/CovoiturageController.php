<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Covoiturage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

/**
 * Covoiturage controller.
 *
 */
class CovoiturageController extends Controller
{
    /**
     * Lists all covoiturage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $covoiturages = $em->getRepository('BackOfficeBundle:Covoiturage')->findAll();

        return $this->render('@BackOffice/covoiturage/index.html.twig', array(
            'covoiturages' => $covoiturages,
        ));
    }

    /**
     * Creates a new covoiturage entity.
     *
     */
    public function newAction(Request $request)
    {
        $covoiturage = new Covoiturage();
        $form = $this->createForm('BackOfficeBundle\Form\CovoiturageType', $covoiturage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hasComplexError = false;

            $repository = $this->getDoctrine()->getRepository(Covoiturage::class);
            $covoiturages = $repository->getCovoiturageOfTrajet($covoiturage->getTrajet());
            
            if(count($covoiturages) >= $covoiturage->getTrajet()->getNbPlace() + 1) {
                $form->get("trajet")->addError(new FormError("Toutes les places pour ce trajet sont déjà prises"));
                $hasComplexError = true;
            }

            $driverCount = 0;
            foreach($covoiturages as $c) {
                if($c->getTypeCovoit()->getType() == "Conducteur") {
                    $driverCount++;
                }
            }
            
            if($covoiturage->getTypeCovoit()->getType() == "Conducteur" && $driverCount > 0) {
                $form->get("typeCovoit")->addError(new FormError("Un conducteur a déjà été assigné à ce trajet"));
                $hasComplexError = true;
            }

            if($covoiturage->getTypeCovoit()->getType() == "Passager" && is_null($covoiturage->getCo2())) {
                $form->get("co2")->addError(new FormError("Un passager doit être associé à une économie de Co2"));
                $hasComplexError = true;
            }

            if($covoiturage->getTypeCovoit()->getType() == "Conducteur" && !is_null($covoiturage->getCo2())) {
                $form->get("co2")->addError(new FormError("Un conducteur ne peut pas être associé à une économie de Co2"));
                $hasComplexError = true;
            }

            if(!$hasComplexError) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($covoiturage);
                $em->flush();

                return $this->redirectToRoute('covoiturage_show', array('id' => $covoiturage->getId()));
            }
        }

        return $this->render('@BackOffice/covoiturage/new.html.twig', array(
            'covoiturage' => $covoiturage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a covoiturage entity.
     *
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
     * Displays a form to edit an existing covoiturage entity.
     *
     */
    public function editAction(Request $request, Covoiturage $covoiturage)
    {
        $deleteForm = $this->createDeleteForm($covoiturage);
        $editForm = $this->createForm('BackOfficeBundle\Form\CovoiturageType', $covoiturage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('covoiturage_show', array('id' => $covoiturage->getId()));
        }

        return $this->render('@BackOffice/covoiturage/edit.html.twig', array(
            'covoiturage' => $covoiturage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a covoiturage entity.
     *
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
                return $this->render('@BackOffice/Default/dberror.html.twig', [
                    "title" => "Une erreur est survenue lors de la suppression de l'entité",
                    "exception" => $e
                ]);
            }
        }

        return $this->redirectToRoute('covoiturage_index');
    }

    /**
     * Creates a form to delete a covoiturage entity.
     *
     * @param Covoiturage $covoiturage The covoiturage entity
     *
     * @return \Symfony\Component\Form\Form The form
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
