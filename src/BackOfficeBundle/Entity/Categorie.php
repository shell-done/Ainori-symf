<?php

/**
 * Fichier de l'entité 'Categorie'
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
 * Categorie représente une catégorie d'utilisateur
 * 
 * Categorie représente une catégorie d'utilisateur comme 'Etudiant',
 * 'Enseignant' ou 'Externe'
 * Deux catégories ne peuvent pas avoir le même nom
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\CategorieRepository")
 * @UniqueEntity(fields="categorie", message="Nom de catégorie déjà utilisé")
 */
class Categorie
{
    /**
     * Nom de la catégorie, doit contenir entre 2 et 50 caractères
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 2, 
     *  minMessage = "Ce champ est trop court, il doit faire 2 caractères ou plus",
     *  max = 50,
     *  maxMessage = "Ce champ est trop long, il doit faire 50 caractères ou moins"
     * )
     * @ORM\Column(name="categorie", type="string", length=50, nullable=false)
     */
    private $categorie;

    /**
     * Identifiant de la catégorie
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set l'attribut categorie
     *
     * @param string $categorie
     *
     * @return Categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get l'attribut categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
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
     * La chaine de caractères est composée du nom de la catégorie (attribut categorie)
     * Exemple : 'Enseignant'
     * 
     * @return string
     */
    public function __toString() {
        return $this->categorie;
    }
}
