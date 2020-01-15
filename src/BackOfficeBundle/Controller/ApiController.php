<?php

/**
 * Fichier du controller 'APIController' utilisé pour gérer les différentes pages
 * relatives à l'API
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Controller utilisé pour l'affichage des pages relatives à l'API
 * 
 * Les pages relatives à l'API sont :
 *  - La documentation
 * 
 * CE CONTROLLER NE DÉFINIT PAS LES REQUÊTES RELATIVES A L'API, CELLES-CI SONT
 * PRÉSENTES DANS LE WEBSERVICEBUNDLE
 * 
 * D'autres pages en lien avec l'API (affichage des statistiques, activation/désactivation 
 * des requêtes) pourront être rajouté dans le futur
 */
class ApiController extends Controller {

    /**
     * Affiche la page de documentation de l'API
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la page documentation
     */
    public function documentationAction() {
        return $this->render('@BackOffice/api/documentation.html.twig');
    }
}
