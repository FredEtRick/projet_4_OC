<?php
    namespace Test\Fmd\PersonneBundle\Entity;

    use Fmd\PersonneBundle\Entity\Personne;
    use PHPUnit\Framework\TestCase;

    class PersonneTest extends TestCase
    {
        public function testGetTarifJourneeMoins4()
        {
            $bebe = new Personne();
            $naissance = date('d-m-Y');
            $annee = substr($naissance, 6);
            $annee -= 3; // Enfant de 3 ans en guise d'exemple, ne prend plus de date fixe en toutes lettres mais date du jour moins 3 ans, pour que le test soit bon même si on le refait dans plusieurs années.
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            $bebe->setDateNaissance($naissance);
            
            $result = $bebe->getTarifJournee();
            
            $this->assertSame(0, $result);
        }
        
        public function testGetTarifJourneeEnfant() // 4 a 12 compris
        {
            $enfant = new Personne();
            $naissance = date('d-m-Y');
            $annee = substr($naissance, 6);
            $annee -= 6;
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            $enfant->setDateNaissance($naissance);
            
            $result = $enfant->getTarifJournee();
            
            $this->assertSame(8, $result);
        }
    }