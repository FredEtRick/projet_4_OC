<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filiere
 *
 * @ORM\Table(name="filiere")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\FiliereRepository")
 */
class Filiere
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomFiliere", type="string", length=255, unique=true)
     */
    private $nomFiliere;

    /**
     * @var int
     *
     * @ORM\Column(name="nombreEtudiants", type="integer")
     */
    private $nombreEtudiants;

    /**
     * @var string
     *
     * @ORM\Column(name="nomProfEnCharge", type="string", length=255)
     */
    private $nomProfEnCharge;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomFiliere
     *
     * @param string $nomFiliere
     *
     * @return Filiere
     */
    public function setNomFiliere($nomFiliere)
    {
        $this->nomFiliere = $nomFiliere;

        return $this;
    }

    /**
     * Get nomFiliere
     *
     * @return string
     */
    public function getNomFiliere()
    {
        return $this->nomFiliere;
    }

    /**
     * Set nombreEtudiants
     *
     * @param integer $nombreEtudiants
     *
     * @return Filiere
     */
    public function setNombreEtudiants($nombreEtudiants)
    {
        $this->nombreEtudiants = $nombreEtudiants;

        return $this;
    }

    /**
     * Get nombreEtudiants
     *
     * @return int
     */
    public function getNombreEtudiants()
    {
        return $this->nombreEtudiants;
    }

    /**
     * Set nomProfEnCharge
     *
     * @param string $nomProfEnCharge
     *
     * @return Filiere
     */
    public function setNomProfEnCharge($nomProfEnCharge)
    {
        $this->nomProfEnCharge = $nomProfEnCharge;

        return $this;
    }

    /**
     * Get nomProfEnCharge
     *
     * @return string
     */
    public function getNomProfEnCharge()
    {
        return $this->nomProfEnCharge;
    }
}

