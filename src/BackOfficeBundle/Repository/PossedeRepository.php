<?php

/**
 * Fichier du repository 'Possede'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

use BackOfficeBundle\Entity\Utilisateur;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'possede'
 */
class PossedeRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère une entité 'possede' définie par son id
     *
     * @param int $id l'id de l'entité a récupérer
     *  
     * @return Possede|null l'entité demandée ou null si celle-ci n'existe pas
     */
    public function getPossede($id) {
        $em = $this->createQueryBuilder("p")
            ->select(["p", "v", "m"])
            ->innerJoin("p.voiture", "v")
            ->innerJoin("v.marque", "m")
            ->where("p.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /**
     * Récupère la liste des entités 'possede' d'un utilisateur
     *
     * @param int $id l'id de l'utilisateur
     * 
     * @return array la liste des entités
     */
    public function getPossedesUtilisateur($id) {
        $em = $this->createQueryBuilder("p")
            ->select(["p", "v", "m"])
            ->innerJoin("p.voiture", "v")
            ->innerJoin("v.marque", "m")
            ->innerJoin("p.utilisateur", "u")
            ->where("u.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        return $em->getArrayResult();
    }
    
}
