<?php

/**
 * Fichier du repository 'Marque'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'marque'
 */
class MarqueRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'marque'
     * 
     * @return array la liste des entités
     */
    public function getMarques() {
        $em = $this->createQueryBuilder("m")
            ->getQuery();
        
        return $em->getArrayResult();
    }
    
}