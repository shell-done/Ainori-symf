<?php

/**
 * Fichier de l'entité 'Trajet'
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
 * Trajet représente un trajet de covoiturage entre deux villes
 *
 * @ORM\Table(name="trajet", indexes={@ORM\Index(name="trajet_ville_FK", columns={"id_ville"}), @ORM\Index(name="trajet_ville0_FK", columns={"id_ville_ville_arrivee"}), @ORM\Index(name="trajet_possede1_FK", columns={"id_possede"}), @ORM\Index(name="trajet_type_trajet2_FK", columns={"id_type_trajet"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\TrajetRepository")
 */
class Trajet
{
    /**
     * La date de départ du trajet
     * @var \DateTime
     * 
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @ORM\Column(name="date_depart", type="date", nullable=false)
     */
    private $dateDepart;

    /**
     * L'instant (heure/minute) de départ du trajet
     * @var \DateTime
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @ORM\Column(name="heure_depart", type="time", nullable=false)
     */
    private $heureDepart;

    /**
     * Le nombre de place passager proposées pour ce trajet, doit être strictement inférieur au nombre de place du véhicule
     * @var integer
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\GreaterThanOrEqual(
     *  value = 1,
     *  message = "Le nombre de place doit être strictement positif"
     * )
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     */
    private $nbPlace;

    /**
     * Durée du trajet en heures
     * @var float|null
     *
     * @ORM\Column(name="duree", type="float", precision=10, scale=0, nullable=true)
     */
    private $duree;

    /**
     * Commentaire du trajet
     * @var string|null
     *
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=true)
     */
    private $commentaire;

    /**
     * Distance entre la ville de départ et la ville d'arrivée, doit être strictement positive
     * @var float
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\GreaterThan(
     *  value = 0,
     *  message = "La distance parcourue doit être strictement positive"
     * )
     * @ORM\Column(name="nb_km", type="float", precision=10, scale=0, nullable=false)
     */
    private $nbKm;

    /**
     * L'identifiant du trajet
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Voiture utilisée pour le trajet
     * @var \BackOfficeBundle\Entity\Possede
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Possede")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_possede", referencedColumnName="id")
     * })
     */
    private $possede;

    /**
     * Type de trajet (Régulier ou Ponctuel)
     * @var \BackOfficeBundle\Entity\TypeTrajet
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\TypeTrajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_trajet", referencedColumnName="id")
     * })
     */
    private $typeTrajet;

    /**
     * Ville d'arrivée du trajet
     * @var \BackOfficeBundle\Entity\Ville
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville_ville_arrivee", referencedColumnName="id")
     * })
     */
    private $villeArrivee;

    /**
     * Ville de départ du trajet
     * @var \BackOfficeBundle\Entity\Ville
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     * })
     */
    private $villeDepart;

    /**
     * Constructeur de la classe
     * 
     * Initialise la date et l'heure de départ à l'instant présent
     */
    public function __construct() {
        $now = new \DateTime();
        $this->dateDepart = new \DateTime($now->format("Y-m-d"));
        $this->heureDepart = new \DateTime($now->format("H:i"));
    }

    /**
     * Set l'attribut dateDepart
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
     * Get l'attribut dateDepart
     *
     * @return \DateTime
     */
    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    /**
     * Set l'attribut heureDepart
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
     * Get l'attribut heureDepart
     *
     * @return \DateTime
     */
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set l'attribut nbPlace
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
     * Get l'attribut nbPlace
     *
     * @return integer
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
    }

    /**
     * Set l'attribut duree
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
     * Get l'attribut duree
     *
     * @return float
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set l'attribut commentaire
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
     * Get l'attribut commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set l'attribut nbKm
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
     * Get l'attribut nbKm
     *
     * @return float
     */
    public function getNbKm()
    {
        return $this->nbKm;
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
     * Set l'attribut possede
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
     * Get l'attribut possede
     *
     * @return \BackOfficeBundle\Entity\Possede
     */
    public function getPossede()
    {
        return $this->possede;
    }

    /**
     * Set l'attribut typeTrajet
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
     * Get l'attribut typeTrajet
     *
     * @return \BackOfficeBundle\Entity\TypeTrajet
     */
    public function getTypeTrajet()
    {
        return $this->typeTrajet;
    }

    /**
     * Set l'attribut villeArrivee
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
     * Get l'attribut villeArrivee
     *
     * @return \BackOfficeBundle\Entity\Ville
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }

    /**
     * Set l'attribut villeDepart
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
     * Get l'attribut villeDepart
     *
     * @return \BackOfficeBundle\Entity\Ville
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }

    /**
     * Converti l'objet en une chaine de caractères
     * 
     * La chaine de caractères est composée du nom de la ville de départ
     * et de celui de la ville d'arrivée
     * Exemple : 'De Brest à Paris'
     * 
     * @return string
     */
    public function __toString() {
        return "De " . $this->villeDepart . " à " . $this->villeArrivee;
    }
}
