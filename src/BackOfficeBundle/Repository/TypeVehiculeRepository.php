<?php

/**
 * Fichier du repository 'TypeVehicule'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'typeVehicule'
 */
class TypeVehiculeRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'typeVehicule'
     * 
     * @return array la liste des entités
     */
    public function getTypeVehicules() {
        $em = $this->createQueryBuilder("tv")
            ->getQuery();
        
        return $em->getArrayResult();
    }
    
}