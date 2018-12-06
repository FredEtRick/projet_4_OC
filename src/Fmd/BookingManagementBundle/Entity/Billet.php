<?php

namespace Fmd\BookingManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billet
 *
 * @ORM\Table(name="billet")
 * @ORM\Entity(repositoryClass="Fmd\BookingManagementBundle\Repository\BilletRepository")
 */
class Billet
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
     * @ORM\ManyToOne(targetEntity="Fmd\PersonneBundle\Entity\Personne")
     * @ORM\JoinColumn(name="personne_id", referencedColumnName="id", nullable=false)
     */
    private $personne;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fmd\BookingManagementBundle\Entity\Reservation", inversedBy="billets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;

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
     * Set personne
     *
     * @param \Fmd\PersonneBundle\Entity\Personne $personne
     *
     * @return Billet
     */
    public function setPersonne(\Fmd\PersonneBundle\Entity\Personne $personne = null)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \Fmd\PersonneBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set reservation
     *
     * @param  $reservation
     *
     * @return Billet
     */
    public function setReservation($reservation)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return 
     */
    public function getReservation()
    {
        return $this->reservation;
    }
    
    public function getTarif()
    {
        $tarif = 0;
        $dateReservation = $this->reservation->getDateReservation();
        $dateNaissance = $this->personne->getDateNaissance();
        $age = date_format($dateReservation, 'Y') - date_format($dateNaissance, 'Y');
        if (date_format($dateReservation, 'm') < date_format($dateNaissance, 'm'))
            $age--;
        elseif(date_format($dateReservation, 'm') == date_format($dateNaissance, 'm') && date_format($dateReservation, 'd') < date_format($dateNaissance, 'd'))
            $age--;
        
        if ($age < 4)
            $tarif = 0;
        elseif ($age < 12)
            $tarif = 8;
        elseif ($this->personne->getReduction())
            $tarif = 10;
        elseif ($age >= 60)
            $tarif = 12;
        else
            $tarif = 16;

        if ($this->reservation->getDemiJournee())
            $tarif /= 2;
        return $tarif;
    }
}
