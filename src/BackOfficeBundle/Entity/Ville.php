<?php

/**
 * Fichier de l'entité 'Ville'
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
 * Ville représente une ville française
 * 
 * Deux villes ne peuvent pas avoir le même code INSEE
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\VilleRepository")
 * @UniqueEntity(fields="codeInsee", message="Code INSEE déjà utilisé")
 */
class Ville
{
    /**
     * Code INSEE de la ville, doit être composé d'exactement 5 chiffres
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Regex(
     *  pattern = "/^[0-9]{5}$/",
     *  message = "Ce champ doit être composé d'exactement 5 chiffres"
     * )
     * @ORM\Column(name="code_insee", type="string", length=5, nullable=false)
     */
    private $codeInsee;

    /**
     * Nom de la ville, doit contenir entre 2 et 50 caractères
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 2, 
     *  minMessage = "Ce champ est trop court, il doit faire 2 caractères ou plus",
     *  max = 50,
     *  maxMessage = "Ce champ est trop long, il doit faire 50 caractères ou moins"
     * )
     * @ORM\Column(name="ville", type="string", length=50, nullable=false)
     */
    private $ville;

    /**
     * Code postal de la ville, doit être composé d'exactement 5 chiffres
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Regex(
     *  pattern = "/^[0-9]{5}$/",
     *  message = "Ce champ doit être composé d'exactement 5 chiffres"
     * )
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=false)
     */
    private $codePostal;

    /**
     * Numéro du département de la ville, doit être composé de 1 à 5 chiffres
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Regex(
     *  pattern = "/^[0-9]{1,5}$/",
     *  message = "Ce champ doit être composé de 1 à 5 chiffres"
     * )
     * @ORM\Column(name="dep", type="string", length=5, nullable=false)
     */
    private $dep;

    /**
     * Identifiant de la ville
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set l'attribut codeInsee
     *
     * @param string $codeInsee
     *
     * @return Ville
     */
    public function setCodeInsee($codeInsee)
    {
        $this->codeInsee = $codeInsee;

        return $this;
    }

    /**
     * Get l'attribut codeInsee
     *
     * @return string
     */
    public function getCodeInsee()
    {
        return $this->codeInsee;
    }

    /**
     * Set l'attribut ville
     *
     * @param string $ville
     *
     * @return Ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get l'attribut ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set l'attribut codePostal
     *
     * @param string $codePostal
     *
     * @return Ville
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get l'attribut codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set l'attribut dep
     *
     * @param string $dep
     *
     * @return Ville
     */
    public function setDep($dep)
    {
        $this->dep = $dep;

        return $this;
    }

    /**
     * Get l'attribut dep
     *
     * @return string
     */
    public function getDep()
    {
        return $this->dep;
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
     * Converti l'objet en une chaine de caractères
     * 
     * La chaine de caractères est composée du nom de la ville
     * Exemple : 'Brest'
     * 
     * @return string
     */
    public function __toString() {
        return $this->ville;
    }
}
