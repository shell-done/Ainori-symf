<?php

namespace BackOfficeBundle\Repository;

/**
 * TypeTrajetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypeTrajetRepository extends \Doctrine\ORM\EntityRepository {

    public function getTypesTrajet() {
        $em = $this->createQueryBuilder("tt")
            ->getQuery();
        
        return $em->getArrayResult();
    }
    
}