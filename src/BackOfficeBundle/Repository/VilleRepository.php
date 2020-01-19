<?php

/**
 * Fichier du repository 'Ville'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'ville'
 * 
 * Les requêtes sont les suivantes :
 *  - getVilles : GET
 */
class VilleRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'ville'
     *
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getVilles($hydrated = false) {
        $em = $this->createQueryBuilder("v")
            ->getQuery();
        
        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }
    
}