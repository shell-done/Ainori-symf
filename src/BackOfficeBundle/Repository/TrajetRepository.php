<?php

namespace BackOfficeBundle\Repository;

use BackOfficeBundle\Entity\Ville;

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

    public function getTrajet($id) {
        $em = $this->createQueryBuilder("t")
            ->where("t.id = :id")
            ->setParameter("id", $id)
            ->getQuery();

        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function getTrajets($trajet) {
        $em = $this->createQueryBuilder("t")
            ->innerJoin("t.typeTrajet", "typeT")
            ->innerJoin("t.villeDepart", "villeD")
            ->innerJoin("t.villeArrivee", "villeA")
            ->where("t.heureDepart = :heureDepart")
            ->andWhere("t.dateDepart = :dateDepart")
            ->andWhere("villeD = :villeDepart")
            ->andWhere("villeA = :villeArrivee")
            ->andWhere("typeT = :typeTrajet")
            ->setParameter("heureDepart", $trajet->getHeureDepart())
            ->setParameter("dateDepart", $trajet->getDateDepart())
            ->setParameter("villeDepart", $trajet->getVilleDepart())
            ->setParameter("villeArrivee", $trajet->getVilleArrivee())
            ->setParameter("typeTrajet", $trajet->getTypeTrajet())
            ->getQuery();

        return $em->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function deleteTrajet($id) {
        $em = $this->createQueryBuilder("t")
            ->delete()
            ->where("t.id = :id")
            ->setParameter("id", $id)
            ->getQuery();
        
        return $em->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
