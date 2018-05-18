<?php

namespace Fmd\BookingManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="Fmd\BookingManagementBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var array
     *
     * @ORM\Column(name="personnes", type="simple_array")
     */
    private $personnes;

    /**
     * @var array
     *
     * @ORM\Column(name="billets", type="simple_array")
     */
    private $billets;


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
     * Set mail
     *
     * @param string $mail
     *
     * @return Reservation
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

    /**
     * Set personnes
     *
     * @param array $personnes
     *
     * @return Reservation
     */
    public function setPersonnes($personnes)
    {
        $this->personnes = $personnes;

        return $this;
    }

    /**
     * Get personnes
     *
     * @return array
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }

    /**
     * Set billets
     *
     * @param array $billets
     *
     * @return Reservation
     */
    public function setBillets($billets)
    {
        $this->billets = $billets;

        return $this;
    }

    /**
     * Get billets
     *
     * @return array
     */
    public function getBillets()
    {
        return $this->billets;
    }
}

