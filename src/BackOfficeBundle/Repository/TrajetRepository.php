<?php

namespace BackOfficeBundle\Repository;

/**
 * TrajetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrajetRepository extends \Doctrine\ORM\EntityRepository {
    
    public function getLastTrajets($nbOfTrajets) {
        if($nbOfTrajets < 1)
            return null;

        $em = $this->createQueryBuilder("t")
            ->orderBy("t.id", "DESC")
            ->setMaxResults($nbOfTrajets)
            ->getQuery();

        return $em->getResult();
    }

    public function countTrajets() {
        return $this->createQueryBuilder("t")
            ->select("COUNT(t.id)")
            ->getQuery()->getSingleScalarResult();
    }

    public function findTrajet($id) {
        $em = $this->createQueryBuilder("t")
            ->where("t.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findTrajets($trajet) {
        $em = $this->createQueryBuilder("t")
            ->innerJoin("BackOfficeBundle:TypeTrajet", "type")
            ->where("t.dateDepart = :dateDepart")
            ->andWhere("t.heureDepart = :heureDepart")
            ->andWhere("t.villeDepart = :villeDepart")
            ->andWhere("t.villeArrivee = :villeArrivee")
            ->andWhere("t.typeTrajet = :typeTrajet")
            ->setParameter("dateDepart", $trajet->getDateDepart())
            ->setParameter("heureDepart", $trajet->getHeureDepart())
            ->setParameter("villeDepart", $trajet->getVilleDepart())
            ->setParameter("villeArrivee", $trajet->getVilleArrivee())
            ->setParameter("typeTrajet", $trajet->getTypeTrajet())
            ->getQuery();

        return $em->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
