<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Covoiturage
 *
 * @ORM\Table(name="covoiturage", indexes={@ORM\Index(name="covoiturage_utilisateur_FK", columns={"id_utilisateur"}), @ORM\Index(name="covoiturage_co20_FK", columns={"id_co2"}), @ORM\Index(name="covoiturage_type_covoit1_FK", columns={"id_type_covoit"}), @ORM\Index(name="covoiturage_trajet2_FK", columns={"id_trajet"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\CovoiturageRepository")
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
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Co2")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_co2", referencedColumnName="id")
     * })
     */
    private $co2;

    /**
     * @var \BackOfficeBundle\Entity\Trajet
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Trajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_trajet", referencedColumnName="id")
     * })
     */
    private $trajet;

    /**
     * @var \BackOfficeBundle\Entity\TypeCovoit
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\TypeCovoit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_covoit", referencedColumnName="id")
     * })
     */
    private $typeCovoit;

    /**
     * @var \BackOfficeBundle\Entity\Utilisateur
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $utilisateur;

    public function __construct() {
        $now = new \DateTime();
        $this->created = new \DateTime($now->format("Y-m-d H:i"));
        $this->updated = new \DateTime($now->format("Y-m-d H:i"));
    }

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
     * Set co2
     *
     * @param \BackOfficeBundle\Entity\Co2 $co2
     *
     * @return Covoiturage
     */
    public function setCo2(\BackOfficeBundle\Entity\Co2 $co2 = null)
    {
        $this->co2 = $co2;

        return $this;
    }

    /**
     * Get co2
     *
     * @return \BackOfficeBundle\Entity\Co2
     */
    public function getCo2()
    {
        return $this->co2;
    }

    /**
     * Set trajet
     *
     * @param \BackOfficeBundle\Entity\Trajet $trajet
     *
     * @return Covoiturage
     */
    public function setTrajet(\BackOfficeBundle\Entity\Trajet $trajet = null)
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * Get trajet
     *
     * @return \BackOfficeBundle\Entity\Trajet
     */
    public function getTrajet()
    {
        return $this->trajet;
    }

    /**
     * Set typeCovoit
     *
     * @param \BackOfficeBundle\Entity\TypeCovoit $typeCovoit
     *
     * @return Covoiturage
     */
    public function setTypeCovoit(\BackOfficeBundle\Entity\TypeCovoit $typeCovoit = null)
    {
        $this->typeCovoit = $typeCovoit;

        return $this;
    }

    /**
     * Get typeCovoit
     *
     * @return \BackOfficeBundle\Entity\TypeCovoit
     */
    public function getTypeCovoit()
    {
        return $this->typeCovoit;
    }

    /**
     * Set utilisateur
     *
     * @param \BackOfficeBundle\Entity\Utilisateur $utilisateur
     *
     * @return Covoiturage
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
}
