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
     * @var bool
     *
     * @ORM\Column(name="journeeEntiere", type="boolean")
     */
    private $journeeEntiere;


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
     * Set journeeEntiere
     *
     * @param boolean $journeeEntiere
     *
     * @return Billet
     */
    public function setJourneeEntiere($journeeEntiere)
    {
        $this->journeeEntiere = $journeeEntiere;

        return $this;
    }

    /**
     * Get journeeEntiere
     *
     * @return bool
     */
    public function getJourneeEntiere()
    {
        return $this->journeeEntiere;
    }
}

