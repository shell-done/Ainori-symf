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
     * @return array la liste des entités
     */
    public function getTypeCovoits() {
        $em = $this->createQueryBuilder("tc")
            ->getQuery();
        
        return $em->getArrayResult();
    }
    
}