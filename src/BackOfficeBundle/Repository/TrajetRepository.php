<?php

/**
 * Fichier du repository 'Trajet'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

use BackOfficeBundle\Entity\Ville;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'trajet'
 */
class TrajetRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la liste des dernières entités 'trajet' créées
     *
     * @param int $nbOfTrajets le nombre de trajets souhaité
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     * 
     * @return array|null la liste des entités ou null si le nombre de trajet demandé est inférieur à 1
     */
    public function getLastTrajets($nbOfTrajets, $hydrated = false) {
        if($nbOfTrajets < 1)
            return null;

        $em = $this->createQueryBuilder("t")
            ->orderBy("t.id", "DESC")
            ->setMaxResults($nbOfTrajets)
            ->getQuery();
        
        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getArrayResult();

        // Retour sous la forme d'un tableau d'entité
        return $em->getResult();
    }

    /**
     * Compte le nombre d'entités 'trajet'
     * 
     * @return int le nombre d'entité 'trajet'
     */
    public function countTrajets() {
        $em = $this->createQueryBuilder("t")
            ->select("COUNT(t.id)")
            ->getQuery();
        
        return $em->getSingleScalarResult();
    }

    /**
     * Récupère une entité 'trajet' défini par son id
     *
     * @param int $id l'id de l'entité
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     *
     * @return Trajet|null l'entité demandée ou null si celle-ci n'existe pas
     */
    public function getTrajet($id, $hydrated = false) {
        $em = $this->createQueryBuilder("t")
            ->select(["t", "villeD", "villeA", "typeT"])
            ->innerJoin("t.villeDepart", "villeD")
            ->innerJoin("t.villeArrivee", "villeA")
            ->innerJoin("t.typeTrajet", "typeT")
            ->where("t.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        // Retour sous la forme d'un tableau d'entité
        return $em->getOneOrNullResult();
    }

    /**
     * Récupère la liste des entités 'trajet' filtrée avec certains paramètres
     *
     * @param Trajet $trajet l'entité 'trajet' avec les choix de filtre
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     * 
     * @return array la liste des entités
     */
    public function getTrajets($trajet, $hydrated = false) {
        // Création de la requête
        $em = $this->createQueryBuilder("t");
        $em->select(["t", "villeD", "villeA", "typeT"]);

        // Ajout des jointures
        $em->innerJoin("t.villeDepart", "villeD");
        $em->innerJoin("t.villeArrivee", "villeA");
        $em->innerJoin("t.typeTrajet", "typeT");

        // Ajout des conditions
        // Permet d'utiliser "andWhere()" dans les prochaines requêtes sans avoir à vérifier s'il y a eu un "where()" avant
        $em->where("true = true");

        if($trajet->getHeureDepart())
            $em->andWhere("t.heureDepart BETWEEN :heureDepart_avant AND :heureDepart_apres");

        if($trajet->getDateDepart())
            $em->andWhere("t.dateDepart = :dateDepart");

        if($trajet->getVilleDepart())
            $em->andWhere("villeD = :villeDepart");

        if($trajet->getVilleArrivee())
            $em->andWhere("villeA = :villeArrivee");

        if($trajet->getTypeTrajet())
            $em->andWhere("typeT = :typeTrajet");

        // Ajout des paramètres
        if($trajet->getHeureDepart())
            $em->setParameters([
                // On récupère les trajets proposés entre 2h avant et 2h après l'heure demandée
                "heureDepart_avant" => $trajet->getHeureDepart()->sub(new \DateInterval("PT2H")),
                "heureDepart_apres" => $trajet->getHeureDepart()->add(new \DateInterval("PT2H"))
            ]);

        if($trajet->getDateDepart())
            $em->setParameter("dateDepart", $trajet->getDateDepart());

        if($trajet->getVilleDepart())
            $em->setParameter("villeDepart", $trajet->getVilleDepart());

        if($trajet->getVilleArrivee())
            $em->setParameter("villeArrivee", $trajet->getVilleArrivee());

        if($trajet->getTypeTrajet())
            $em->setParameter("typeTrajet", $trajet->getTypeTrajet());
        
        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getQuery()->getArrayResult();

        // Retour sous la forme d'un tableau d'entité
        return $em->getQuery()->getResult();
    }

}
