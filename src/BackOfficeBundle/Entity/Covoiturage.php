<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Covoiturage
 *
 * @ORM\Table(name="covoiturage", indexes={@ORM\Index(name="covoiturage_utilisateur_FK", columns={"id_utilisateur"}), @ORM\Index(name="covoiturage_co20_FK", columns={"id_co2"}), @ORM\Index(name="covoiturage_type_covoit1_FK", columns={"id_type_covoit"}), @ORM\Index(name="covoiturage_trajet2_FK", columns={"id_trajet"})})
 * @ORM\Entity
 */
class Covoiturage
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackOfficeBundle\Entity\Co2
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Co2")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_co2", referencedColumnName="id")
     * })
     */
    private $idCo2;

    /**
     * @var \BackOfficeBundle\Entity\Trajet
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Trajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_trajet", referencedColumnName="id")
     * })
     */
    private $idTrajet;

    /**
     * @var \BackOfficeBundle\Entity\TypeCovoit
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\TypeCovoit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_covoit", referencedColumnName="id")
     * })
     */
    private $idTypeCovoit;

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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Covoiturage
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Covoiturage
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
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
     * Set idCo2
     *
     * @param \BackOfficeBundle\Entity\Co2 $idCo2
     *
     * @return Covoiturage
     */
    public function setIdCo2(\BackOfficeBundle\Entity\Co2 $idCo2 = null)
    {
        $this->idCo2 = $idCo2;

        return $this;
    }

    /**
     * Get idCo2
     *
     * @return \BackOfficeBundle\Entity\Co2
     */
    public function getIdCo2()
    {
        return $this->idCo2;
    }

    /**
     * Set idTrajet
     *
     * @param \BackOfficeBundle\Entity\Trajet $idTrajet
     *
     * @return Covoiturage
     */
    public function setIdTrajet(\BackOfficeBundle\Entity\Trajet $idTrajet = null)
    {
        $this->idTrajet = $idTrajet;

        return $this;
    }

    /**
     * Get idTrajet
     *
     * @return \BackOfficeBundle\Entity\Trajet
     */
    public function getIdTrajet()
    {
        return $this->idTrajet;
    }

    /**
     * Set idTypeCovoit
     *
     * @param \BackOfficeBundle\Entity\TypeCovoit $idTypeCovoit
     *
     * @return Covoiturage
     */
    public function setIdTypeCovoit(\BackOfficeBundle\Entity\TypeCovoit $idTypeCovoit = null)
    {
        $this->idTypeCovoit = $idTypeCovoit;

        return $this;
    }

    /**
     * Get idTypeCovoit
     *
     * @return \BackOfficeBundle\Entity\TypeCovoit
     */
    public function getIdTypeCovoit()
    {
        return $this->idTypeCovoit;
    }

    /**
     * Set idUtilisateur
     *
     * @param \BackOfficeBundle\Entity\Utilisateur $idUtilisateur
     *
     * @return Covoiturage
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
}
