<?php

/**
 * Fichier de l'entité 'Co2'
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
 * Co2 représente la quantité (en kg) de Co2 économisé pour un passager
 * sur un trajet 
 *
 * @ORM\Table(name="co2")
 * @ORM\Entity
 */
class Co2
{
    /**
     * Quantité de Co2 (en kg) économisée
     * @var float
     *
     * @ORM\Column(name="val_co2", type="float", precision=10, scale=0, nullable=false)
     */
    private $valCo2;

    /**
     * Définit si l'économie de Co2 est active
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * Identifiant de l'économie de Co2
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set l'attribut valCo2
     *
     * @param float $valCo2
     *
     * @return Co2
     */
    public function setValCo2($valCo2)
    {
        $this->valCo2 = $valCo2;

        return $this;
    }

    /**
     * Get l'attribut valCo2
     *
     * @return float
     */
    public function getValCo2()
    {
        return $this->valCo2;
    }

    /**
     * Set l'attribut actif
     *
     * @param boolean $actif
     *
     * @return Co2
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get l'attribut actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
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
     * La chaine de caractères est composée de la quantité de Co2 économisé
     * arrondi à 3 chiffres après la virgule suivi de ' kg'
     * Exemple : '61.700 kg'
     * 
     * @return string
     */
    public function __toString() {
        return strval(number_format($this->valCo2, 3)) . " kg";
    }
}
