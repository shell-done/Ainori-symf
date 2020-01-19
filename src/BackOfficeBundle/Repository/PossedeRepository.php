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
 * 
 * Les requêtes sont les suivantes :
 *  - getPossede : GET
 *  - getPossedesUtilisateur : GET
 */
class PossedeRepository extends \Doctrine\ORM\EntityRepository {

    /**
     * Récupère une entité 'possede' définie par son id
     *
     * @param Integer $id l'id de l'entité
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Possede le résultat de la requête
     */
    public function getPossede($id, $hydrated = false) {
        $em = $this->createQueryBuilder("p")
            ->where("p.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        if($hydrated)
            return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        return $em->getOneOrNullResult();
    }

    /**
     * Récupère la liste des entités 'possede' d'un utilisateur
     *
     * @param Integer $id l'id de l'utilisateur
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getPossedesUtilisateur($id, $hydrated = false) {
        $em = $this->createQueryBuilder("p")
            ->innerJoin("p.utilisateur", "u")
            ->where("u.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }
    
}
