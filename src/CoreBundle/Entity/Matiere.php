<?php
    namespace CoreBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Table(name="core_matiere")
     * @ORM\Entity(repositoryClass="CoreBundle\Repository\MatiereRepository", readOnly=true)
     */
    class Matiere
    {
        /**
         * @ORM\Column(name="idMatiere", type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;
        
        /**
         * @ORM\Column(name="nomMatiere", type="string", length=255)
         */
        protected $nomMatiere;
        
        /**
         * @ORM\Column(name="coef", type="integer")
         */
        protected $coef;

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
         * Set nomMatiere
         *
         * @param string $nomMatiere
         *
         * @return Matiere
         */
        public function setNomMatiere($nomMatiere)
        {
            $this->nomMatiere = $nomMatiere;

            return $this;
        }

        /**
         * Get nomMatiere
         *
         * @return string
         */
        public function getNomMatiere()
        {
            return $this->nomMatiere;
        }

        /**
         * Set coef
         *
         * @param integer $coef
         *
         * @return Matiere
         */
        public function setCoef($coef)
        {
            $this->coef = $coef;

            return $this;
        }

        /**
         * Get coef
         *
         * @return int
         */
        public function getCoef()
        {
            return $this->coef;
        }
    }
?>