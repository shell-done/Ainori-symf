<?php

/**
 * Fichier du repository 'TypeCovoit'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'typeCovoit'
 * 
 * La requête est la suivante :
 *  - getTypeCovoits : GET
 */
class TypeCovoitRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'typeCovoit'
     *
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getTypeCovoits($hydrated = false) {
        $em = $this->createQueryBuilder("tc")
            ->getQuery();
        
        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }
    
}