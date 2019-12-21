<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture", indexes={@ORM\Index(name="voiture_marque_FK", columns={"id_marque"}), @ORM\Index(name="voiture_type_vehicule0_FK", columns={"id_type_vehicule"})})
 * @ORM\Entity
 */
class Voiture
{
    /**
     * @var string
     *
     * @ORM\Column(name="modele", type="string", length=50, nullable=false)
     */
    private $modele;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackOfficeBundle\Entity\Marque
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Marque")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_marque", referencedColumnName="id")
     * })
     */
    private $marque;

    /**
     * @var \BackOfficeBundle\Entity\TypeVehicule
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\TypeVehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_vehicule", referencedColumnName="id")
     * })
     */
    private $typeVehicule;



    /**
     * Set modele
     *
     * @param string $modele
     *
     * @return Voiture
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return string
     */
    public function getModele()
    {
        return $this->modele;
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
     * Set marque
     *
     * @param \BackOfficeBundle\Entity\Marque $marque
     *
     * @return Voiture
     */
    public function setMarque(\BackOfficeBundle\Entity\Marque $marque = null)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \BackOfficeBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set typeVehicule
     *
     * @param \BackOfficeBundle\Entity\TypeVehicule $typeVehicule
     *
     * @return Voiture
     */
    public function setTypeVehicule(\BackOfficeBundle\Entity\TypeVehicule $typeVehicule = null)
    {
        $this->typeVehicule = $typeVehicule;

        return $this;
    }

    /**
     * Get typeVehicule
     *
     * @return \BackOfficeBundle\Entity\TypeVehicule
     */
    public function getTypeVehicule()
    {
        return $this->typeVehicule;
    }

    /**
     * Convert the object to string
     * 
     * @return string
     */
    public function __toString() {
        return $this->typeVehicule . " " . $this->modele . " " . $this->marque;
    }
}
