<?php

/**
 * Fichier du repository 'TypeTrajet'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'typeTrajet'
 * 
 * La requête est la suivante :
 *  - getTypeTrajets : GET
 */
class TypeTrajetRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'typeTrajet'
     *
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getTypeTrajets($hydrated = false) {
        $em = $this->createQueryBuilder("tt")
            ->getQuery();
        
        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }
    
}