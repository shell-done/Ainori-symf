<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Possede
 *
 * @ORM\Table(name="possede", indexes={@ORM\Index(name="possede_utilisateur_FK", columns={"id_utilisateur"}), @ORM\Index(name="possede_voiture0_FK", columns={"id_voiture"})})
 * @ORM\Entity
 */
class Possede
{
    /**
     * @var string
     *
     * @ORM\Column(name="immatriculation", type="string", length=15, nullable=false)
     */
    private $immatriculation;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     */
    private $nbPlace;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackOfficeBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $utilisateur;

    /**
     * @var \BackOfficeBundle\Entity\Voiture
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Voiture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_voiture", referencedColumnName="id")
     * })
     */
    private $voiture;



    /**
     * Set immatriculation
     *
     * @param string $immatriculation
     *
     * @return Possede
     */
    public function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * Get immatriculation
     *
     * @return string
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Possede
     */
    public function setNbPlace($nbPlace)
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get nbPlace
     *
     * @return integer
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
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
     * Set utilisateur
     *
     * @param \BackOfficeBundle\Entity\Utilisateur $utilisateur
     *
     * @return Possede
     */
    public function setUtilisateur(\BackOfficeBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \BackOfficeBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set voiture
     *
     * @param \BackOfficeBundle\Entity\Voiture $voiture
     *
     * @return Possede
     */
    public function setVoiture(\BackOfficeBundle\Entity\Voiture $voiture = null)
    {
        $this->voiture = $voiture;

        return $this;
    }

    /**
     * Get voiture
     *
     * @return \BackOfficeBundle\Entity\Voiture
     */
    public function getVoiture()
    {
        return $this->voiture;
    }

    /**
     * Convert the object to string
     * 
     * @return string
     */
    public function __toString() {
        return $this->$voiture . " immatriculée " . $this->immatriculation;
    }
}
