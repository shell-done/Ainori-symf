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
 */
class TypeTrajetRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère un tableau php représentant les entités 'typeTrajet'
     *
     * @return array la liste des entités
     */
    public function getTypeTrajets() {
        $em = $this->createQueryBuilder("t")
            ->getQuery();
        
        return $em->getArrayResult();
    }
    
}