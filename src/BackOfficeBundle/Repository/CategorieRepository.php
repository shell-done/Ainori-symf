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
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     * 
     * @return array la liste des entités
     */
    public function getCategories($hydrated = false) {
        $em = $this->createQueryBuilder("c")
            ->getQuery();
        
        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getArrayResult();

        // Retour sous la forme d'un tableau d'entité
        return $em->getResult();
    }

}