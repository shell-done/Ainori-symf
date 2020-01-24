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
     * 
     * @return array|null la liste des entités ou null si le nombre de trajet demandés est inférieur à 1
     */
    public function getLastTrajets($nbOfTrajets) {
        if($nbOfTrajets < 1)
            return null;

        $em = $this->createQueryBuilder("t")
            ->orderBy("t.id", "DESC")
            ->setMaxResults($nbOfTrajets)
            ->getQuery();
        
        return $em->getResult();
    }

    /**
     * Compte le nombre d'entités 'trajet'
     * 
     * @return int le nombre d'entités 'trajet'
     */
    public function countTrajets() {
        $em = $this->createQueryBuilder("t")
            ->select("COUNT(t.id)")
            ->getQuery();
        
        return $em->getSingleScalarResult();
    }

    /**
     * Récupère un tableau php représentant une entité 'trajet' complète
     *
     * @param int $id l'id du trajet à récupérer
     * 
     * @return Trajet|null l'entité demandée sous forme de tableau ou null si celle-ci n'existe pas
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

        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /**
     * Récupère un tableau php représentant un résumé des entités 'trajet' filtrée avec certains paramètres
     * 
     * @param Trajet $trajet l'entité 'trajet' avec les choix de filtre
     * 
     * @return array la liste des entités
     */
    public function getTrajets($trajet) {
        // Création de la requête
        $em = $this->createQueryBuilder("t");
        
        // Récupération des attributs principaux d'un trajet
        $em->select("t.id, villeD.ville AS villeDepart, villeA.ville as villeArrivee,
                        t.dateDepart, t.heureDepart, t.nbPlace, t.duree, t.commentaire,
                        t.nbKm, typeT.typeTrajet");
        
        // Récupération du nombre de place occupées
        $em->addSelect("(SELECT COUNT(covoit.id) - 1 FROM BackOfficeBundle:Covoiturage covoit
                        WHERE covoit.trajet = t) AS placeOccupee");

        // Récupération du nom de la voiture
        $em->addSelect("(SELECT CONCAT(m.marque, ' ', v.modele) FROM BackOfficeBundle:Voiture v, BackOfficeBundle:Marque m 
                        WHERE possede.voiture = v AND v.marque = m) AS voiture");

        // Récupération du nom de l'utilisateur
        $em->addSelect("(SELECT CONCAT(u.prenom, ' ', u.nom) FROM BackOfficeBundle:Utilisateur u, BackOfficeBundle:Covoiturage c, BackOfficeBundle:TypeCovoit tc
                        WHERE c.trajet = t AND c.typeCovoit = tc AND tc.type = 'Conducteur' AND c.utilisateur = u) AS utilisateur");

        // Ajout des jointures
        $em->innerJoin("t.villeDepart", "villeD");
        $em->innerJoin("t.villeArrivee", "villeA");
        $em->innerJoin("t.possede", "possede");
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
        if($trajet->getHeureDepart()) {
            $before = clone $trajet->getHeureDepart();
            $before->sub(new \DateInterval("PT2H"));
            $after = clone $trajet->getHeureDepart();
            $after->add(new \DateInterval("PT2H"));

            $em->setParameters([
                // On récupère les trajets proposés entre 2h avant et 2h après l'heure demandée
                "heureDepart_avant" => $before,
                "heureDepart_apres" => $after
            ]);
        }

        if($trajet->getDateDepart())
            $em->setParameter("dateDepart", $trajet->getDateDepart());

        if($trajet->getVilleDepart())
            $em->setParameter("villeDepart", $trajet->getVilleDepart());

        if($trajet->getVilleArrivee())
            $em->setParameter("villeArrivee", $trajet->getVilleArrivee());

        if($trajet->getTypeTrajet())
            $em->setParameter("typeTrajet", $trajet->getTypeTrajet());
        
        return $em->getQuery()->getArrayResult();
    }

}
