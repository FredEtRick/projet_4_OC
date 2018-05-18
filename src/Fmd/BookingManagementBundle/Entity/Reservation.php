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
     * @ORM\OneToMany(targetEntity="Fmd\BookingManagementBundle\Entity\Billet", mappedBy="reservation")
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
     * Set billets
     *
     * @param array $billets
     *
     * @return Reservation
     */
    public function setBillets($billets)
    {
        $this->billets = $billets;
        
        foreach($this->billets as $billet)
            $billet->setReservation($this);
        
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->billets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add billet
     *
     * @param \Fmd\BookingManagementBundle\Entity\Billet $billet
     *
     * @return Reservation
     */
    public function addBillet(\Fmd\BookingManagementBundle\Entity\Billet $billet)
    {
        $this->billets[] = $billet;
        $billet->setReservation($this);

        return $this;
    }

    /**
     * Remove billet
     *
     * @param \Fmd\BookingManagementBundle\Entity\Billet $billet
     */
    public function removeBillet(\Fmd\BookingManagementBundle\Entity\Billet $billet)
    {
        $this->billets->removeElement($billet);
    }
}
