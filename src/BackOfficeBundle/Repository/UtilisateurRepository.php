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
 * 
 * Les requêtes sont les suivantes :
 *  - getLastUtilisateurs : GET
 *  - countUtilisateurs : GET
 *  - getUtilisateur : GET
 */
class UtilisateurRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des dernières entités 'utilisateur' créées
     *
     * @param Integer $nbOfUtilisateurs le nombre d'utilisateurs souhaité
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getLastUtilisateurs($nbOfUtilisateurs, $hydrated = false) {
        if($nbOfUtilisateurs < 1)
            return null;

        $em = $this->createQueryBuilder("u")
            ->orderBy("u.id", "DESC")
            ->setMaxResults($nbOfUtilisateurs)
            ->getQuery();

        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }

    /**
     * Récupère le nombre d'entités 'utilisateur'
     * 
     * @return Integer le résultat de la requête
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
     * @param Integer $id l'id de l'entité
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Utilisateur le résultat de la requête
     */
    public function getUtilisateur($id, $hydrated = false) {
        $em = $this->createQueryBuilder("u")
            ->where("u.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        if($hydrated)
            return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $em->getOneOrNullResult();
    }
    
}
