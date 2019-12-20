<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Co2
 *
 * @ORM\Table(name="co2")
 * @ORM\Entity
 */
class Co2
{
    /**
     * @var float
     *
     * @ORM\Column(name="val_co2", type="float", precision=10, scale=0, nullable=false)
     */
    private $valCo2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set valCo2
     *
     * @param float $valCo2
     *
     * @return Co2
     */
    public function setValCo2($valCo2)
    {
        $this->valCo2 = $valCo2;

        return $this;
    }

    /**
     * Get valCo2
     *
     * @return float
     */
    public function getValCo2()
    {
        return $this->valCo2;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Co2
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
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
