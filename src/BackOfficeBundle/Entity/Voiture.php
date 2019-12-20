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
    private $idMarque;

    /**
     * @var \BackOfficeBundle\Entity\TypeVehicule
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\TypeVehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_vehicule", referencedColumnName="id")
     * })
     */
    private $idTypeVehicule;



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
     * Set idMarque
     *
     * @param \BackOfficeBundle\Entity\Marque $idMarque
     *
     * @return Voiture
     */
    public function setIdMarque(\BackOfficeBundle\Entity\Marque $idMarque = null)
    {
        $this->idMarque = $idMarque;

        return $this;
    }

    /**
     * Get idMarque
     *
     * @return \BackOfficeBundle\Entity\Marque
     */
    public function getIdMarque()
    {
        return $this->idMarque;
    }

    /**
     * Set idTypeVehicule
     *
     * @param \BackOfficeBundle\Entity\TypeVehicule $idTypeVehicule
     *
     * @return Voiture
     */
    public function setIdTypeVehicule(\BackOfficeBundle\Entity\TypeVehicule $idTypeVehicule = null)
    {
        $this->idTypeVehicule = $idTypeVehicule;

        return $this;
    }

    /**
     * Get idTypeVehicule
     *
     * @return \BackOfficeBundle\Entity\TypeVehicule
     */
    public function getIdTypeVehicule()
    {
        return $this->idTypeVehicule;
    }
}
