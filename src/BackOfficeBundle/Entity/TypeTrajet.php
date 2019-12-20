<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeTrajet
 *
 * @ORM\Table(name="type_trajet")
 * @ORM\Entity
 */
class TypeTrajet
{
    /**
     * @var string
     *
     * @ORM\Column(name="type_trajet", type="string", length=50, nullable=false)
     */
    private $typeTrajet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set typeTrajet
     *
     * @param string $typeTrajet
     *
     * @return TypeTrajet
     */
    public function setTypeTrajet($typeTrajet)
    {
        $this->typeTrajet = $typeTrajet;

        return $this;
    }

    /**
     * Get typeTrajet
     *
     * @return string
     */
    public function getTypeTrajet()
    {
        return $this->typeTrajet;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
