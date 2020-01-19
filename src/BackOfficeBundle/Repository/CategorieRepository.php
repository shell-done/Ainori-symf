<?php

/**
 * Fichier du repository 'Categorie'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'categorie'
 * 
 * Les requêtes sont les suivantes :
 *  - getCategories : GET
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'categorie'
     *
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getCategories($hydrated = false) {
        $em = $this->createQueryBuilder("c")
            ->getQuery();
        
        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }
    
}