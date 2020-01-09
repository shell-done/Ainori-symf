<?php

namespace BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TypeTrajet
 *
 * @ORM\Table(name="type_trajet")
 * @ORM\Entity(repositoryClass="BackOfficeBundle\Repository\TypeTrajetRepository")
 * @UniqueEntity(fields="typeTrajet", message="Ce type est déjà utilisé")
 */
class TypeTrajet
{
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
     * @ORM\Column(name="type_trajet", type="string", length=50, nullable=false)
     */
    private $typeTrajet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set typeTrajet
     *
     * @param string $typeTrajet
     *
     * @return TypeTrajet
     */
    public function setTypeTrajet($typeTrajet)
    {
        $this->typeTrajet = $typeTrajet;

        return $this;
    }

    /**
     * Get typeTrajet
     *
     * @return string
     */
    public function getTypeTrajet()
    {
        return $this->typeTrajet;
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
     * Convert the object to string
     * 
     * @return string
     */
    public function __toString() {
        return $this->typeTrajet;
    }
}
