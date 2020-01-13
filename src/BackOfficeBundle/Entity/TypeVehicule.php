<?php

/**
 * Fichier de l'entité 'TypeVehicule'
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
 * TypeVehicule représente un type de véhicule
 * 
 * TypeVehicule représente un type de véhicule comme 'Break', 'Coupé'
 * ou 'Pickup'
 * Deux typeVehicules ne peuvent pas avoir le même nom
 *
 * @ORM\Table(name="type_vehicule")
 * @ORM\Entity
 * @UniqueEntity(fields="type", message="Ce type est déjà utilisé")
 */
class TypeVehicule
{
    /**
     * Nom du type de véhicule, doit contenir entre 2 et 50 caractères
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
     * Identifiant du type de véhicule
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
     * @return TypeVehicule
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
     * La chaine de caractères est composée du nom du type de véhicule
     * Exemple : 'Monospace'
     * 
     * @return string
     */
    public function __toString() {
        return $this->type;
    }
}
