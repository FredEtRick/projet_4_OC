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
     * @var \DateTime
     * 
     * @ORM\Column(name="dateReservation", type="date")
     */
    private $dateReservation;

    /**
     * @var bool
     *
     * @ORM\Column(name="demiJournee", type="boolean")
     */
    private $demiJournee;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        /*
        Finalement, numReservation remplacé par id en auto incrémente clé primaire de table dans BDD !!!
        
        // pour que le numéro de réservation soit unique, on y insère le timestamp et l'ip (deux numéros identiques signifierait deux réservations en même temps avec le même IP) et pour plus d'assurance, on y ajoute un code aléatoire.
        $timeStamp = time();
        $ip = $_SERVER['REMOTE_ADDR'];
        $hash = sha1($timeStamp . $ip); // le timestamp et l'ip sont hashés pour préserver la vie privée du visiteur
        $caracteres = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890';
        $melange = substr(str_shuffle($caracteres), 0, 12);
        $this->numReservation = $hash . $melange;*/
        
        // La date de réservation est celle a laquelle on veut venir, pas la date du jour !!! Doit être renseignée dans le formulaire !
        //$this->dateReservation = new \DateTime();
        
        //$this->billets = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     *
     * @return Reservation
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    public function getDateReservationString()
    {
        return $this->dateReservation->format('d/m/Y H:i:s');
    }

    /**
     * Set demiJournee
     *
     * @param boolean $demiJournee
     *
     * @return Billet
     */
    public function setDemiJournee($demiJournee)
    {
        $this->demiJournee = $demiJournee;

        return $this;
    }

    /**
     * Get demiJournee
     *
     * @return bool
     */
    public function getDemiJournee()
    {
        return $this->demiJournee;
    }
}
