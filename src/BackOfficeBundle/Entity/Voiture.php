<?php

/**
 * Fichier de l'entité 'Voiture'
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
 * Voiture représente un modèle de voiture
 * 
 * Deux voitures ne peuvent pas avoir le même nom de modèle et la même marque
 *
 * @ORM\Table(name="voiture", indexes={@ORM\Index(name="voiture_marque_FK", columns={"id_marque"}), @ORM\Index(name="voiture_type_vehicule0_FK", columns={"id_type_vehicule"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\VoitureRepository")
 * @UniqueEntity(fields={"modele", "marque"}, message="Cette voiture existe déjà")
 */
class Voiture
{
    /**
     * Nom du modèle de voiture, doit contenir entre 2 et 50 caractères
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 2, 
     *  minMessage = "Ce champ est trop court, il doit faire 2 caractères ou plus",
     *  max = 50,
     *  maxMessage = "Ce champ est trop long, il doit faire 50 caractères ou moins"
     * )
     * @ORM\Column(name="modele", type="string", length=50, nullable=false)
     */
    private $modele;

    /**
     * Identifiant de la voiture
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Constructeur du véhicule
     * @var \BackOfficeBundle\Entity\Marque
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Marque")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_marque", referencedColumnName="id")
     * })
     */
    private $marque;

    /**
     * Type de véhicule
     * @var \BackOfficeBundle\Entity\TypeVehicule
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\TypeVehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_vehicule", referencedColumnName="id")
     * })
     */
    private $typeVehicule;



    /**
     * Set l'attribut modele
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
     * Get l'attribut modele
     *
     * @return string
     */
    public function getModele()
    {
        return $this->modele;
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
     * Set l'attribut marque
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
     * Get l'attribut marque
     *
     * @return \BackOfficeBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set l'attribut typeVehicule
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
     * Get l'attribut typeVehicule
     *
     * @return \BackOfficeBundle\Entity\TypeVehicule
     */
    public function getTypeVehicule()
    {
        return $this->typeVehicule;
    }

    /**
     * Converti l'objet en une chaine de caractères
     * 
     * La chaine de caractères est composée du nom de la marque suivie
     * du modèle
     * Exemple : 'Audi R8'
     * 
     * @return string
     */
    public function __toString() {
        return $this->marque . " " . $this->modele;
    }
}
