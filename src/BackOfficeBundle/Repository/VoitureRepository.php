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
     * @param int $id_marque l'id de la marque de la voiture
     * 
     * @return array la liste des entités
     */
    public function getVoitures($id_marque = null) {
        $em = $this->createQueryBuilder("v")
            ->select(["v", "m"])
            ->innerJoin("v.marque", "m")
            ->where("m.id = :id")
            ->setParameter("id", $id_marque)
            ->getQuery();
        
        return $em->getArrayResult();
    }
    
}