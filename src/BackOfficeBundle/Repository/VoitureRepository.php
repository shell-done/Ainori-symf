<?php

/**
 * Fichier du repository 'Voiture'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'voiture'
 */
class VoitureRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des entités 'voiture'
     *
     * @param int $id l'id de la marque de la voiture
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     * 
     * @return array la liste des entités
     */
    public function getVoitures($id, $hydrated = false) {
        $em = $this->createQueryBuilder("v")
            ->select(["v", "m"])
            ->innerJoin("v.marque", "m")
            ->where("m.id = :id")
            ->setParameter("id", $id)
            ->getQuery();
        
        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getArrayResult();

        // Retour sous la forme d'un tableau d'entité
        return $em->getResult();
    }
    
}