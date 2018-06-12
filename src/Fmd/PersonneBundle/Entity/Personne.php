<?php

namespace Fmd\PersonneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity(repositoryClass="Fmd\PersonneBundle\Repository\PersonneRepository")
 */
class Personne
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
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var bool
     *
     * @ORM\Column(name="reduction", type="boolean")
     */
    private $reduction;


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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Personne
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Personne
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
     * Set pays
     *
     * @param string $pays
     *
     * @return Personne
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Personne
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set reduction
     *
     * @param boolean $reduction
     *
     * @return Personne
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * Get reduction
     *
     * @return bool
     */
    public function getReduction()
    {
        return $this->reduction;
    }
    
    public function getTarifJournee()
    {
        // note : énnoncé ne précise pas impact choix "demi journée" sur le tarif... Divise par deux ? Note : Si choix demi journée a un impact sur le prix, je devrais surement migrer la méthode vers l'entité billet, pour avoir accès au type de billet (puis parce que c'est plus approprié) ou plutot dans réservation : il y aura le détail des prix + le prix total pour paiement
        
        $aujourdhui = new \Datetime();
        $dateNaissance = $this->getDateNaissance();
        $age = date_format($aujourdhui, 'Y') - date_format($dateNaissance, 'Y');
        if (date_format($aujourdhui, 'm') < date_format($dateNaissance, 'm'))
            $age--;
        elseif(date_format($aujourdhui, 'm') == date_format($dateNaissance, 'm') && date_format($aujourdhui, 'd') < date_format($dateNaissance, 'd'))
            $age--;
        
        if ($age < 4)
            return 0;
        if ($age < 12)
            return 8;
        if ($this->getReduction())
            return 10;
        if ($age >= 60)
            return 12;
        return 16;
    }
    
    /*public function getTarifDemiJournee()
    {
        return $this->getTarifJournee() / 2;
    } plutot faire la manip direct dans billet en fonction de type billet ?*/
}

