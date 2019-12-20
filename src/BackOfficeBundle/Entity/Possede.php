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
    private $idUtilisateur;

    /**
     * @var \BackOfficeBundle\Entity\Voiture
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Voiture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_voiture", referencedColumnName="id")
     * })
     */
    private $idVoiture;



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
     * Set idUtilisateur
     *
     * @param \BackOfficeBundle\Entity\Utilisateur $idUtilisateur
     *
     * @return Possede
     */
    public function setIdUtilisateur(\BackOfficeBundle\Entity\Utilisateur $idUtilisateur = null)
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get idUtilisateur
     *
     * @return \BackOfficeBundle\Entity\Utilisateur
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set idVoiture
     *
     * @param \BackOfficeBundle\Entity\Voiture $idVoiture
     *
     * @return Possede
     */
    public function setIdVoiture(\BackOfficeBundle\Entity\Voiture $idVoiture = null)
    {
        $this->idVoiture = $idVoiture;

        return $this;
    }

    /**
     * Get idVoiture
     *
     * @return \BackOfficeBundle\Entity\Voiture
     */
    public function getIdVoiture()
    {
        return $this->idVoiture;
    }
}
