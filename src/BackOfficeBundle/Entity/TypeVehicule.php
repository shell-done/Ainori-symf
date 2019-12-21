<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeVehicule
 *
 * @ORM\Table(name="type_vehicule")
 * @ORM\Entity
 */
class TypeVehicule
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set type
     *
     * @param string $type
     *
     * @return TypeVehicule
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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

    /**
     * Convert the object to string
     * 
     * @return string
     */
    public function __toString() {
        return $this->type;
    }
}
