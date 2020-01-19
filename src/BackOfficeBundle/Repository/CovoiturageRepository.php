<?php

/**
 * Fichier du repository 'Covoiturage'
 * 
 * @author Margaux DOUDET <margaux.doudet@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package WebServiceBundle
 */

namespace BackOfficeBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use BackOfficeBundle\Entity\Trajet;
use BackOfficeBundle\Entity\Utilisateur;

use \Datetime;

/**
 * Repository utilisé pour gérer les requêtes relatives à l'API de la table 'covoiturage'
 * 
 * Les requêtes sont les suivantes :
 *  - getCo2EconomyByMonth : GET
 *  - getCovoiturageOfTrajet : GET
 *  - getCovoituragesUtilisateur : GET
 *  - getCovoitsAsConducteur : POST
 */
class CovoiturageRepository extends \Doctrine\ORM\EntityRepository {

    /**
     * Récupère le nombre de Co2 économisé par mois, en ne prenant en compte que les covoiturages ponctuels et passagers
     * 
     * @return array le résultat de la requête
     */
    public function getCo2EconomyByMonth() {
        $currentYear = intval((new DateTime())->format("Y")); 

        $em = $this->createQueryBuilder("covoit")
                ->select("MONTH(trajet.dateDepart) as month, SUM(co2.valCo2) as tot")
                ->innerJoin("covoit.co2", "co2")
                ->innerJoin("covoit.trajet", "trajet")
                ->innerJoin("trajet.typeTrajet", "type")
                ->where("type.typeTrajet = 'Ponctuel'")
                ->andWhere("YEAR(trajet.dateDepart) = :currentYear")
                ->andWhere("co2.actif = true")
                ->setParameter("currentYear", $currentYear)
                ->groupBy("month")
                ->orderBy("month")
                ->getQuery();

        $res = $em->getResult();

        $co2SavedByMonth = array_fill(0, 12, 0);

        foreach($res as $r) {
            $co2SavedByMonth[$r["month"] - 1] = number_format($r["tot"], 1);
        }

        return $co2SavedByMonth;
    }

    /**
     * Récupère la liste des entités 'covoiturage'
     *
     * @param Trajet $trajet l'entité 'trajet' associé au covoiturage
     * 
     * @return Array le résultat de la requête
     */
    public function getCovoiturageOfTrajet($trajet, $hydrated = false) {
        $em = $this->createQueryBuilder("covoit")
            ->select(["covoit", "trajet"])
            ->innerJoin("covoit.trajet", "trajet")
            ->where("trajet = :trajet")
            ->setParameter("trajet", $trajet)
            ->getQuery();
        
        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }

    /**
     * Récupère la liste des entités 'covoiturage' d'un utilisateur
     *
     * @param Integer $id l'id de l'utilisateur
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getCovoituragesUtilisateur($id, $hydrated = false) {
        $em = $this->createQueryBuilder("covoit")
            ->select(["covoit", "t", "u"])
            ->innerJoin("covoit.trajet", "t")
            ->innerJoin("covoit.utilisateur", "u")
            ->where("u.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        if($hydrated)
            return $em->getArrayResult();

        return $em->getResult();
    }

    /**
     * Récupère la liste des entités 'covoiturage' qu'un utilisateur a créé
     *
     * @param Integer $id l'id de l'utilisateur
     * @param Boolean $hydrated
     *      si $hydrated = true, le résultat est un tableau d'entité
     *      si $hydrated = false, le résultat est un tableau associatif représentant l'entité
     * 
     * @return Array le résultat de la requête
     */
    public function getCovoitsAsConducteur($id, $hydrated = false) {
        $em = $this->createQueryBuilder("c")
            ->select(["c", "t", "villeD", "villeA", "typeT", "typeC"])
            ->innerJoin("c.trajet", "t")
            ->innerJoin("t.villeDepart", "villeD")
            ->innerJoin("t.villeArrivee", "villeA")
            ->innerJoin("t.typeTrajet", "typeT")
            ->innerJoin("c.typeCovoit", "typeC")
            ->innerJoin("c.utilisateur", "u")
            ->where("typeC.type = 'Conducteur'")
            ->where("u.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        if($hydrated)
            return $em->getArrayResult();
        
        return $em->getResult();
    }

}
