<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="utilisateur_ville_FK", columns={"id_ville"}), @ORM\Index(name="utilisateur_categorie0_FK", columns={"id_categorie"})})
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\UtilisateurRepository")
 * @UniqueEntity(fields="mail", message="Adresse mail déjà utilisée")
 */
class Utilisateur implements UserInterface
{
    /**
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
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=150, nullable=false)
     */
    private $password;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     *
     * @Assert\Regex(
     *  pattern = "/^[0-9]{10}$/",
     *  message = "Ce champ doit être composé d'exactement 10 chiffres"
     * )
     * @ORM\Column(name="telephone", type="string", length=10, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @Assert\Length(
     *  max = 100,
     *  maxMessage = "Ce champ est trop long, il doit faire 100 caractères ou moins"
     * )
     * @ORM\Column(name="adresse", type="string", length=100, nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
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
     * @var \BackOfficeBundle\Entity\Ville
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="BackOfficeBundle\Entity\Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     * })
     */
    private $ville;

    
    public function __construct() {
        $this->roles = ['ROLE_USER'];
    }

    /**
     * Set mail
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
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    public function getUsername() {
        return $this->mail;
    }

    /**
     * Set nom
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
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
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
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set plainPassword
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
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set password
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
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set telephone
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
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set adresse
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
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
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
     * Set categorie
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
     * Get categorie
     *
     * @return \BackOfficeBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set ville
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
     * Get ville
     *
     * @return \BackOfficeBundle\Entity\Ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    public function eraseCredentials()
    {
    }

    /**
     * Convert the object to string
     * 
     * @return string
     */
    public function __toString() {
        return $this->prenom . " " . $this->nom;
    }
}
