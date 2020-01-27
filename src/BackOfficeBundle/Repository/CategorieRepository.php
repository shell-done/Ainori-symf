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
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'categorie'
     * 
     * @return array la liste des entités
     */
    public function getCategories() {
        $em = $this->createQueryBuilder("c")
            ->getQuery();
        
        return $em->getArrayResult();
    }

}