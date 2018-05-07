<?php
    namespace CoreBundle\Entity;
    
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Table(name="core_prof")
     * @ORM\Entity(repositoryClass="CoreBundle\Repository\ProfRepository", readOnly=true)
     */
    class Prof
    {
        /**
         * @ORM\Column(name="numProf", type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $numProf;
        
        /**
         * @ORM\Column(name="nomProf", type="string", length=255)
         */
        protected $nomProf;
        
        /**
         * @ORM\Column(name="matiereProf", type="string", length=255)
         */
        protected $matiereProf;

        /**
         * Get numProf
         *
         * @return int
         */
        public function getNumProf()
        {
            return $this->numProf;
        }

        /**
         * Set nomProf
         *
         * @param string $nomFiliere
         *
         * @return Filiere
         */
        public function setNomProf($nomProf)
        {
            $this->nomProf = $nomProf;

            return $this;
        }

        /**
         * Get nomProf
         *
         * @return string
         */
        public function getNomProf()
        {
            return $this->nomProf;
        }
    
    /**
     * Set matiereProf
     *
     * @param string $matiereProf
     *
     * @return Prof
     */
    public function setMatiereProf($matiereProf)
    {
        $this->matiereProf = $matiereProf;

        return $this;
    }

    /**
     * Get matiereProf
     *
     * @return string
     */
    public function getMatiereProf()
    {
        return $this->matiereProf;
    }
}
