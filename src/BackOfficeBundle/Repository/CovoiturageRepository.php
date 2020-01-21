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
 */
class CovoiturageRepository extends \Doctrine\ORM\EntityRepository {
    /**
     * Récupère la quantité de Co2 économisée chaque mois, en ne prenant en 
     * compte que les covoiturages ponctuels
     * 
     * @return array un tableau de 12 cases correspondants à l'économie de Co2 
     *               pour chaque mois (De janvier à l'index 0 et décembre à l'index 11)
     */
    public function getCo2EconomyByMonth() {
        // Récupération de l'année courante
        $currentYear = (new DateTime())->format("Y"); 

        // On effectue entre les tables 'covoiturage', 'co2', 'trajet' et 'typeTrajet'
        // afin de calculer l'économie de Co2 chaque mois de l'année courante (à l'aide du groupBy) 
        // réalisée par les trajets ponctuels
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

        // Le résultat est de la forme [["month" => 1, "tot" => 63.2], ["month" => 2, ...]]
        // Les mois SANS trajet ne sont pas présents dans le tableau
        $res = $em->getResult();

        // On initialise un tableau de 12 cases de 0 (pour les 12 mois)
        $co2SavedByMonth = array_fill(0, 12, 0);

        // On met les résultats de la requêtes dans le tableau précédemment initialisé
        // Cette étape est nécessaire car les mois SANS trajet ne sont pas retournés, or
        // il faut quand même définir l'économie sur ces mois à 0.
        foreach($res as $r) {
            $co2SavedByMonth[$r["month"] - 1] = number_format($r["tot"], 1);
        }

        return $co2SavedByMonth;
    }

    /**
     * Récupère la liste des entités 'covoiturage' associées à un trajet
     *
     * @param int $trajet l'id du trajet des covoiturages
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     * 
     * @return array la liste des entités
     */
    public function getCovoiturageOfTrajet($id, $hydrated = false) {
        $em = $this->createQueryBuilder("covoit")
            ->select(["covoit", "trajet"])
            ->innerJoin("covoit.trajet", "trajet")
            ->where("trajet.id = :trajet")
            ->setParameter("trajet", $id)
            ->getQuery();
        
        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getArrayResult();

        // Retour sous la forme d'un tableau d'entité
        return $em->getResult();
    }

    /**
     * Récupère la liste des entités 'covoiturage' qu'un utilisateur a créé
     *
     * @param int $id l'id de l'utilisateur
     * @param string|null $typeCovoit
     *      si $typeCovoit = null, tous les covoiturages sont récupérés
     *      sinon, seuls ceux dont le typeCovoit est celui passé en paramètre (comme 'Conducteur' ou 'Passager')
     *      sont récupérés
     * @param bool $hydrated
     *      si $hydrated = FALSE, le résultat est un tableau d'entités
     *      si $hydrated = TRUE, le résultat est un tableau associatif représentant l'entité
     * 
     * @return array la liste des entités
     */
    public function getCovoituragesOfUtilisateur($id, $typeCovoit = null, $hydrated = false) {
        $em = $this->createQueryBuilder("c")
            ->select(["c", "t", "villeD", "villeA", "typeT", "typeC"])
            ->innerJoin("c.trajet", "t")
            ->innerJoin("t.villeDepart", "villeD")
            ->innerJoin("t.villeArrivee", "villeA")
            ->innerJoin("t.typeTrajet", "typeT")
            ->innerJoin("c.typeCovoit", "typeC")
            ->innerJoin("c.utilisateur", "u")
            ->where("u.id = :id");

        if($typeCovoit) {
            $em->andWhere("typeC.type = :typeTrajet");
            $em->setParameter("typeTrajet", ucwords($typeCovoit));
        }

        $em->setParameter("id", $id);

        // Retour sous la forme d'un tableau associatif
        if($hydrated)
            return $em->getQuery()->getArrayResult();
        
        // Retour sous la forme d'un tableau d'entité
        return $em->getQuery()->getResult();
    }

}
