<?php

/**
 * Fichier de l'entité 'Covoiturage'
 * 
 * Ce fichier a été généré par Symfony, pour plus d'informations :
 * https://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html
 * 
 * @author Alexandre THOMAS <alexandre.thomas@isen-ouest.yncrea.fr>
 * @version 1.0.0
 * @package BackOfficeBundle
 */

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Covoiturage représente la participation d'un utilisateur à un trajet
 * 
 * Un covoiturage est unique par rapport à un trajet et un utilisateur.
 * Un utilisateur ne peut donc pas faire partie d'un trajet plusieurs
 * fois
 *
 * @ORM\Table(name="covoiturage", indexes={@ORM\Index(name="covoiturage_utilisateur_FK", columns={"id_utilisateur"}), @ORM\Index(name="covoiturage_co20_FK", columns={"id_co2"}), @ORM\Index(name="covoiturage_type_covoit1_FK", columns={"id_type_covoit"}), @ORM\Index(name="covoiturage_trajet2_FK", columns={"id_trajet"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\CovoiturageRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"trajet", "utilisateur"}, message="Cet utilisateur fait déjà partie du trajet")
 */
class Covoiturage
{
    /**
     * Date de création du covoiturage
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * Date de la dernière modification du covoiturage
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * Identifiant du covoiturage
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Économie de Co2 réalisée par ce covoiturage
     * @var \BackOfficeBundle\Entity\Co2|null
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Co2")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_co2", referencedColumnName="id")
     * })
     */
    private $co2;

    /**
     * Trajet réalisé par le covoiturage
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
     * Type de covoiturage (conducteur ou passager)
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
     * Utilisateur effectuant le trajet
     * @var \BackOfficeBundle\Entity\Utilisateur
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $utilisateur;

    /**
     * Met à jour les attributs updated et éventuellement created
     * 
     * Met à jour l'attribut updated avec l'instant présent. Si l'attribut created vaut
     * null, alors celui-ci est aussi définit à l'instant présent
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() {
        $this->updated = new \DateTime();

        if($this->created == null) {
            $this->created = new \DateTime();
        }
    }

    /**
     * Set l'attribut created
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
     * Get l'attribut created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set l'attribut updated
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
     * Get l'attribut updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Get l'attribut id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set l'attribut co2
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
     * Get l'attribut co2
     *
     * @return \BackOfficeBundle\Entity\Co2
     */
    public function getCo2()
    {
        return $this->co2;
    }

    /**
     * Set l'attribut trajet
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
     * Get l'attribut trajet
     *
     * @return \BackOfficeBundle\Entity\Trajet
     */
    public function getTrajet()
    {
        return $this->trajet;
    }

    /**
     * Set l'attribut typeCovoit
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
     * Get l'attribut typeCovoit
     *
     * @return \BackOfficeBundle\Entity\TypeCovoit
     */
    public function getTypeCovoit()
    {
        return $this->typeCovoit;
    }

    /**
     * Set l'attribut utilisateur
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
     * Get l'attribut utilisateur
     *
     * @return \BackOfficeBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
