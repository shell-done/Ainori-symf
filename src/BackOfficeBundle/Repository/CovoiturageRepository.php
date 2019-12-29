<?php

namespace BackOfficeBundle\Repository;

use \Datetime;

/**
 * CovoiturageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CovoiturageRepository extends \Doctrine\ORM\EntityRepository {
    public function getCo2SavedThisMonth() {
        $now = new DateTime(); 

        $query = $this->createQueryBuilder("covoit")
            ->select("sum(co2.valCo2)")
            ->innerJoin("covoit.co2", "co2")
            ->innerJoin("covoit.trajet", "trajet")
            ->innerJoin("trajet.typeTrajet", "type")
            ->where("type.typeTrajet = 'PON'")
            ->andWhere("trajet.dateDepart BETWEEN :start AND :end")
            ->setParameter("start", $now->format("Y-m-1"))
            ->setParameter("end", $now->format("Y-m-t"))
            ->getQuery();

        $res = $query->getSingleScalarResult();

        if($res)
            return $res;

        return 0;
    }

    public function getCovoiturageOfTrajet($trajet) {
        $query = $this->createQueryBuilder("covoit")
            ->innerJoin("covoit.trajet", "trajet")
            ->where("trajet = :trajet")
            ->setParameter("trajet", $trajet)
            ->getQuery();

        return $query->getResult();
    }
}
