<?php

/**
 * Fichier du repository 'Ville'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'ville'
 */
class VilleRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère un tableau php représentant un résumé des entités 'ville' (id et nom)
     *
     * @return array la liste des entités
     */
    public function getVilles() {
        $em = $this->createQueryBuilder("v")
            ->select("v.id, v.ville")
            ->getQuery();

        return $em->getResult();
    }
    
    /**
     * Récupère un tableau php représentant une entité 'ville' complète
     * 
     * @param $id l'id de la ville à récupérer
     *
     * @return array l'entité sous forme de tableau associatif
     */
    public function getVille($id) {
        $em = $this->createQueryBuilder("v")
            ->where("v.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}