<?php

/**
 * Fichier de l'entité 'Possede'
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
 * Possede représente la possession d'une voiture par un utilisateur
 * 
 * Deux possessions ne peuvent pas avoir la même immatriculation
 *
 * @ORM\Table(name="possede", indexes={@ORM\Index(name="possede_utilisateur_FK", columns={"id_utilisateur"}), @ORM\Index(name="possede_voiture0_FK", columns={"id_voiture"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\PossedeRepository")
 * @UniqueEntity(fields="immatriculation", message="Immatriculation déjà utilisée")
 */
class Possede
{
    /**
     * Immatriculation de la voiture possédée, doit contenir entre 7 et 15 caractères
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 7, 
     *  minMessage = "Ce champ est trop court, il doit faire 2 caractères ou plus",
     *  max = 15,
     *  maxMessage = "Ce champ est trop long, il doit faire 15 caractères ou moins"
     * )
     * @ORM\Column(name="immatriculation", type="string", length=15, nullable=false)
     */
    private $immatriculation;

    /**
     * Nombre de place de la voiture, doit être supérieur ou égal à 1
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
     * Identifiant de la possession
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Utilisateur possédant la voiture
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
     * Voiture possédée
     * @var \BackOfficeBundle\Entity\Voiture
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Voiture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_voiture", referencedColumnName="id")
     * })
     */
    private $voiture;



    /**
     * Set l'attribut immatriculation
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
     * Get l'attribut immatriculation
     *
     * @return string
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * Set l'attribut nbPlace
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
     * Get l'attribut nbPlace
     *
     * @return integer
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
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
     * Set l'attribut utilisateur
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
     * Get l'attribut utilisateur
     *
     * @return \BackOfficeBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set l'attribut voiture
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
     * Get l'attribut voiture
     *
     * @return \BackOfficeBundle\Entity\Voiture
     */
    public function getVoiture()
    {
        return $this->voiture;
    }

    /**
     * Converti l'objet en une chaine de caractères
     * 
     * La chaine de caractères est composée du nom de la voiture suivi de
     * l'immatriculation entre parenthèses
     * Exemple : 'Renault Twingo (HR-381-LW)'
     * 
     * @return string
     */
    public function __toString() {
        return $this->voiture . " (" . $this->immatriculation .")";
    }
}
