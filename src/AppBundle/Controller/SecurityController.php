<?php

/**
 * Controller utilisé pour gérer l'authentification pour accéder au back office
 * 
 * Ce controller affiche la page de connexion et gère l'authentification pour accéder 
 * notamment aux pages du back office. Tout accès non authentifiés à une page du back 
 * office redirige sur cette page de connexion.
 * 
 * Pour plus d'informations sur le fonctionnement de l'authentification, se référer à la
 * documentation symfony : https://symfony.com/doc/3.4/security/form_login_setup.html
 * 
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package AppBundle
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller {

    /**
     * Action utilisée pour l'affichage de la page de login et pour la gestion de l'authentification
     * 
     * @param AuthenticationUtils $authenticationUtils la classe qui gère l'authentification (passée automatiquement par symfony)
     * 
     * @return \Symfony\Component\HttpFoundation\Response la vue associée à la page login
     */
    public function loginAction(AuthenticationUtils $authenticationUtils) {
        // Récupère l'erreur d'authentification (le cas échéant)
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupère le dernier nom d'utilisateur entré
        $lastUsername = $authenticationUtils->getLastUsername();

        // Retourne la page de login
        return $this->render('@App/Security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}