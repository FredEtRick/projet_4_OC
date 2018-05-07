<?php
    namespace CoreBundle\Entity;
    
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Table(name="core_etudiant")
     * @ORM\Entity(repositoryClass="CoreBundle\Repository\EtudiantRepository")
     */
    class Etudiant
    {
        /**
         * @ORM\Column(name="numEtudiant", type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $numEtudiant;
        
        /**
         * @ORM\Column(name="nom", type="string", length=255)
         */
        protected $nom;
        
        /**
         * @ORM\Column(name="prenom", type="string", length=255)
         */
        protected $prenom;
        
        /**
         * @ORM\Column(name="dateNaissance", type="date")
         */
        protected $dateNaissance;

        /**
         * Get numEtudiant
         *
         * @return int
         */
        public function getNumEtudiant()
        {
            return $this->numEtudiant;
        }

        /**
         * Set nom
         *
         * @param string $nom
         *
         * @return Etudiant
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
         * @return Etudiant
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
    }
?>