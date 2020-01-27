<?php

/**
 * Fichier du repository 'Utilisateur'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'utilisateur'
 */
class UtilisateurRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des dernières entités 'utilisateur' créées
     *
     * @param int $nbOfUtilisateurs le nombre d'utilisateurs souhaité
     * 
     * @return array|null la liste des entités ou null si le nombre de trajet demandé est inférieur à 1
     */
    public function getLastUtilisateurs($nbOfUtilisateurs) {
        if($nbOfUtilisateurs < 1)
            return null;

        $em = $this->createQueryBuilder("u")
            ->orderBy("u.id", "DESC")
            ->setMaxResults($nbOfUtilisateurs)
            ->getQuery();

        return $em->getArrayResult();
    }

    /**
     * Récupère le nombre d'entités 'utilisateur'
     * 
     * @return int le nombre d'entités 'trajet'
     */
    public function countUtilisateurs() {
        $em = $this->createQueryBuilder("u")
            ->select("COUNT(u.id)")
            ->getQuery();
        
        return $em->getSingleScalarResult();
    }

    /**
     * Récupère une entité 'utilisateur' définie par son id
     *
     * @param int $id l'id de l'entité
     * 
     * @return Utilisateur|null l'entité demandée ou null si celle-ci n'existe pas
     */
    public function getUtilisateur($id) {
        $em = $this->createQueryBuilder("u")
            ->select(["u", "v", "c"])
            ->innerJoin("u.ville", "v")
            ->innerJoin("u.categorie", "c")
            ->where("u.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    
}
