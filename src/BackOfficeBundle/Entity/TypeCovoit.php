<?php

/**
 * Fichier de l'entité 'TypeCovoit'
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
 * TypeCovoit représente un type de covoitureur
 * 
 * TypeCovoit représente un type de covoitureur comme 'Conducteur' 
 * ou 'Passager'
 * Deux typeCovoits ne peuvent pas avoir le même nom
 *
 * @ORM\Table(name="type_covoit")
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\TypeCovoitRepository")
 * @UniqueEntity(fields="type", message="Ce type est déjà utilisé")
 */
class TypeCovoit
{
    /**
     * Nom du type de covoiturage, doit contenir entre 2 et 50 caractères
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 2, 
     *  minMessage = "Ce champ est trop court, il doit faire 2 caractères ou plus",
     *  max = 50,
     *  maxMessage = "Ce champ est trop long, il doit faire 50 caractères ou moins"
     * )
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * Identifiant du type de covoiturage
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set l'attribut type
     *
     * @param string $type
     *
     * @return TypeCovoit
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get l'attribut type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * La chaine de caractères est composée du nom du type de covoiturage
     * Exemple : 'Conducteur'
     * 
     * @return string
     */
    public function __toString() {
        return $this->type;
    }
}
