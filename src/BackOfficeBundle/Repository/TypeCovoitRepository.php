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
 */
class TypeCovoitRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'typeCovoit'
     *
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     *
     * @return array la liste des entités
     */
    public function getTypeCovoits($hydrated = false) {
        $em = $this->createQueryBuilder("tc")
            ->getQuery();
        
        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getArrayResult();

        // Retour sous la forme d'un tableau d'entité
        return $em->getResult();
    }
    
}