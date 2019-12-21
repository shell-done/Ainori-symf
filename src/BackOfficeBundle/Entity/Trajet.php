<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trajet
 *
 * @ORM\Table(name="trajet", indexes={@ORM\Index(name="trajet_ville_FK", columns={"id_ville"}), @ORM\Index(name="trajet_ville0_FK", columns={"id_ville_ville_arrivee"}), @ORM\Index(name="trajet_possede1_FK", columns={"id_possede"}), @ORM\Index(name="trajet_type_trajet2_FK", columns={"id_type_trajet"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\TrajetRepository")
 */
class Trajet
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_depart", type="date", nullable=false)
     */
    private $dateDepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_depart", type="time", nullable=false)
     */
    private $heureDepart;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     */
    private $nbPlace;

    /**
     * @var float
     *
     * @ORM\Column(name="duree", type="float", precision=10, scale=0, nullable=true)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=true)
     */
    private $commentaire;

    /**
     * @var float
     *
     * @ORM\Column(name="nb_km", type="float", precision=10, scale=0, nullable=false)
     */
    private $nbKm;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackOfficeBundle\Entity\Possede
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Possede")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_possede", referencedColumnName="id")
     * })
     */
    private $possede;

    /**
     * @var \BackOfficeBundle\Entity\TypeTrajet
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\TypeTrajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_trajet", referencedColumnName="id")
     * })
     */
    private $typeTrajet;

    /**
     * @var \BackOfficeBundle\Entity\Ville
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville_ville_arrivee", referencedColumnName="id")
     * })
     */
    private $villeArrivee;

    /**
     * @var \BackOfficeBundle\Entity\Ville
     *
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     * })
     */
    private $villeDepart;



    /**
     * Set dateDepart
     *
     * @param \DateTime $dateDepart
     *
     * @return Trajet
     */
    public function setDateDepart($dateDepart)
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    /**
     * Get dateDepart
     *
     * @return \DateTime
     */
    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    /**
     * Set heureDepart
     *
     * @param \DateTime $heureDepart
     *
     * @return Trajet
     */
    public function setHeureDepart($heureDepart)
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    /**
     * Get heureDepart
     *
     * @return \DateTime
     */
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Trajet
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
     * Set duree
     *
     * @param float $duree
     *
     * @return Trajet
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return float
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Trajet
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set nbKm
     *
     * @param float $nbKm
     *
     * @return Trajet
     */
    public function setNbKm($nbKm)
    {
        $this->nbKm = $nbKm;

        return $this;
    }

    /**
     * Get nbKm
     *
     * @return float
     */
    public function getNbKm()
    {
        return $this->nbKm;
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
     * Set possede
     *
     * @param \BackOfficeBundle\Entity\Possede $possede
     *
     * @return Trajet
     */
    public function setPossede(\BackOfficeBundle\Entity\Possede $possede = null)
    {
        $this->possede = $possede;

        return $this;
    }

    /**
     * Get possede
     *
     * @return \BackOfficeBundle\Entity\Possede
     */
    public function getPossede()
    {
        return $this->possede;
    }

    /**
     * Set typeTrajet
     *
     * @param \BackOfficeBundle\Entity\TypeTrajet $typeTrajet
     *
     * @return Trajet
     */
    public function setTypeTrajet(\BackOfficeBundle\Entity\TypeTrajet $typeTrajet = null)
    {
        $this->typeTrajet = $typeTrajet;

        return $this;
    }

    /**
     * Get typeTrajet
     *
     * @return \BackOfficeBundle\Entity\TypeTrajet
     */
    public function getTypeTrajet()
    {
        return $this->typeTrajet;
    }

    /**
     * Set villeArrivee
     *
     * @param \BackOfficeBundle\Entity\Ville $villeArrivee
     *
     * @return Trajet
     */
    public function setVilleArrivee(\BackOfficeBundle\Entity\Ville $villeArrivee = null)
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    /**
     * Get villeArrivee
     *
     * @return \BackOfficeBundle\Entity\Ville
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }

    /**
     * Set villeDepart
     *
     * @param \BackOfficeBundle\Entity\Ville $villeDepart
     *
     * @return Trajet
     */
    public function setVilleDepart(\BackOfficeBundle\Entity\Ville $villeDepart = null)
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    /**
     * Get villeDepart
     *
     * @return \BackOfficeBundle\Entity\Ville
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }

    /**
     * Convert the object to string
     * 
     * @return string
     */
    public function __toString() {
        return "De " . $this->villeDepart . " à " . $this->villeArrivee;
    }
}
