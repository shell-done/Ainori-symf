<?php

/**
 * Fichier de l'entité 'Utilisateur'
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
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Utilisateur représente un utilisateur du service de covoiturage
 * 
 * Deux utilisateurs ne peuvent pas avoir la même adresse mail
 * Le hachage du mot de passe est réalisé par l'interface UserInterface, pour plus d'informations :
 * https://symfony.com/doc/3.4/security/password_encoding.html
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="utilisateur_ville_FK", columns={"id_ville"}), @ORM\Index(name="utilisateur_categorie0_FK", columns={"id_categorie"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\UtilisateurRepository")
 * @UniqueEntity(fields="mail", message="Adresse mail déjà utilisée")
 */
class Utilisateur implements UserInterface
{
    /**
     * Adresse mail de l'utilisateur, doit avoir le format d'un mail et contenir au plus 5 caractères
     * @var string
     * 
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Email
     * @Assert\Length(
     *  max = 50,
     *  maxMessage = "Ce champ est trop long, il doit faire 50 caractères ou moins"
     * )
     * @ORM\Column(name="mail", type="string", length=50, nullable=false)
     */
    private $mail;

    /**
     * Nom de l'utilisateur, doit contenir entre 2 et 50 caractères
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 2, 
     *  minMessage = "Ce champ est trop court, il doit faire 2 caractères ou plus",
     *  max = 50,
     *  maxMessage = "Ce champ est trop long, il doit faire 50 caractères ou moins"
     * )
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * Prénom de l'utilisateur, doit contenir entre 2 et 50 caractères
     * @var string
     *
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 2, 
     *  minMessage = "Ce champ est trop court, il doit faire 2 caractères ou plus",
     *  max = 50,
     *  maxMessage = "Ce champ est trop long, il doit faire 50 caractères ou moins"
     * )
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * Mot de passe non haché demandé à l'utilisateur, doit contenir entre 5 et 4096 caractères
     * @var string
     * 
     * @Assert\NotBlank(message = "Ce champ ne peut pas être vide")
     * @Assert\Length(
     *  min = 5, 
     *  minMessage = "Ce champ est trop court, il doit faire 5 caractères ou plus",
     *  max = 4096,
     *  maxMessage = "Ce champ est trop long, il doit faire 4096 caractères ou moins"
     * )
     */
    private $plainPassword;

    /**
     * Mot de passe haché
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=150, nullable=false)
     */
    private $password;

    /**
     * Roles d'un utilisateur authentifié (pour UserInterface)
     * @var array
     */
    private $roles;

    /**
     * Numéro de téléphone de l'utilisateur, doit contenir 10 chiffres
     * @var string|null
     *
     * @Assert\Regex(
     *  pattern = "/^[0-9]{10}$/",
     *  message = "Ce champ doit être composé d'exactement 10 chiffres"
     * )
     * @ORM\Column(name="telephone", type="string", length=10, nullable=true)
     */
    private $telephone;

    /**
     * Adresse de l'utilisateur
     * @var string|null
     *
     * @Assert\Length(
     *  max = 100,
     *  maxMessage = "Ce champ est trop long, il doit faire 100 caractères ou moins"
     * )
     * @ORM\Column(name="adresse", type="string", length=100, nullable=true)
     */
    private $adresse;

    /**
     * Identifiant de l'utilisateur
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Catégorie d'utilisateur
     * @var \BackOfficeBundle\Entity\Categorie
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     * })
     */
    private $categorie;

    /**
     * Ville de l'utilisateur
     * @var \BackOfficeBundle\Entity\Ville
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     * })
     */
    private $ville;

    
    /**
     * Constructeur de la classe
     * 
     * Définit l'attribut roles
     */
    public function __construct() {
        $this->roles = ['ROLE_USER'];
    }

    /**
     * Set l'attribut mail
     *
     * @param string $mail
     *
     * @return Utilisateur
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get l'attribut mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Get le nom d'utilisateur qui est l'adresse mail
     * 
     * Implémenté pour UserInterface
     */
    public function getUsername() {
        return $this->mail;
    }

    /**
     * Set l'attribut nom
     *
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get l'attribut nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set l'attribut prenom
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get l'attribut prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set l'attribut plainPassword
     *
     * @param string $plainPassword
     *
     * @return Utilisateur
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get l'attribut plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set l'attribut password
     *
     * @param string $password
     *
     * @return Utilisateur
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get l'attribut password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get le salage du hachage
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set l'attribut roles
     *
     * @param array $roles
     *
     * @return Roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Get l'attribut roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set l'attribut telephone
     *
     * @param string $telephone
     *
     * @return Utilisateur
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get l'attribut telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set l'attribut adresse
     *
     * @param string $adresse
     *
     * @return Utilisateur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get l'attribut adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
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
     * Set l'attribut categorie
     *
     * @param \BackOfficeBundle\Entity\Categorie $categorie
     *
     * @return Utilisateur
     */
    public function setCategorie(\BackOfficeBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get l'attribut categorie
     *
     * @return \BackOfficeBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set l'attribut ville
     *
     * @param \BackOfficeBundle\Entity\Ville $ville
     *
     * @return Utilisateur
     */
    public function setVille(\BackOfficeBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get l'attribut ville
     *
     * @return \BackOfficeBundle\Entity\Ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Peut être implémenter pour supprimer plainPassword une fois que celui-ci a été traité
     * 
     * Implémenté pour UserInterface
     */
    public function eraseCredentials()
    {
    }

    /**
     * Converti l'objet en une chaine de caractères
     * 
     * La chaine de caractères est composée du nom et du prénom de l'utilisateur
     * Exemple : 'Dustin Thompson'
     * 
     * @return string
     */
    public function __toString() {
        return $this->prenom . " " . $this->nom;
    }
}
