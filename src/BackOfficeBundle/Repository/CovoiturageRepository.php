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
     * Récupère un tableau php représentant une entité 'covoiturage' complète
     * 
     * @param $id l'id de la covoiturage à récupérer
     *
     * @return array|null l'entité demandée sous forme de tableau ou null si celle-ci n'existe pas
     */
    public function getCovoiturage($id) {
        $em = $this->createQueryBuilder("c")
            ->select("c", "co2", "t", "tc", "u")
            ->innerJoin("c.co2", "co2")
            ->innerJoin("c.trajet", "t")
            ->innerJoin("c.typeCovoit", "tc")
            ->innerJoin("c.utilisateur", "u")
            ->where("c.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /**
     * Récupère un tableau php représentant un résumé des entités 'covoiturage' d'un utilisateur (celles où il est passager)
     * 
     * @param int $id l'id de l'utilisateur
     * 
     * @return array la liste des entités
     */
    public function getCovoituragesOfUtilisateur($id) {
        // Création de la requête
        $em = $this->createQueryBuilder("covoit");
        
        // Récupération des attributs principaux d'un trajet
        $em->select("covoit.id, villeD.ville AS villeDepart, villeA.ville as villeArrivee,
                        t.dateDepart, t.heureDepart, t.nbPlace, t.duree, t.commentaire,
                        t.nbKm, typeT.typeTrajet");
        
        // Récupération du nombre de place occupées
        $em->addSelect("(SELECT COUNT(c1.id) - 1 FROM BackOfficeBundle:Covoiturage c1
                        WHERE c1.trajet = t) AS placeOccupee");

        // Récupération du nom de la voiture
        $em->addSelect("(SELECT CONCAT(m.marque, ' ', v.modele) FROM BackOfficeBundle:Voiture v, BackOfficeBundle:Marque m 
                        WHERE possede.voiture = v AND v.marque = m) AS voiture");

        // Récupération du nom de l'utilisateur
        $em->addSelect("(SELECT CONCAT(u.prenom, ' ', u.nom) FROM BackOfficeBundle:Utilisateur u, BackOfficeBundle:Covoiturage c2, BackOfficeBundle:TypeCovoit tc
                        WHERE c2.trajet = t AND c2.typeCovoit = tc AND tc.type = 'Conducteur' AND c2.utilisateur = u) AS utilisateur");

        // Ajout des jointures
        $em->innerJoin("covoit.trajet", "t");
        $em->innerJoin("t.villeDepart", "villeD");
        $em->innerJoin("t.villeArrivee", "villeA");
        $em->innerJoin("t.possede", "possede");
        $em->innerJoin("t.typeTrajet", "typeT");
        $em->innerJoin("covoit.typeCovoit", "typeCovoit");
        $em->innerJoin("covoit.utilisateur", "util");

        $em->where("util.id = :id");
        $em->andWhere("typeCovoit.type = 'Passager'");

        $em->setParameter("id", $id);
        
        return $em->getQuery()->getArrayResult();
    }

}
