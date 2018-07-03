<?php
    namespace Test\Fmd\PersonneBundle\Entity;

    use Fmd\PersonneBundle\Entity\Personne;
    use PHPUnit\Framework\TestCase;

    class PersonneTest extends TestCase
    {
        public function testGetTarifMoins4()
        {
            $bebe = new Personne();
            
            $naissance = date('d-m-Y');
            $annee = substr($naissance, 6);
            $annee -= 3; // Enfant de 3 ans en guise d'exemple, ne prend plus de date fixe en toutes lettres mais date du jour moins 3 ans, pour que le test soit bon même si on le refait dans plusieurs années.
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            
            $bebe->setDateNaissance($naissance);
            
            $tarifJournee = $bebe->getTarifJournee();
            $tarifDemiJournee = $bebe->getTarifDemiJournee();
            
            $this->assertSame(0, $tarifJournee);
            $this->assertSame(0, $tarifDemiJournee);
        }
        
        public function testGetTarifEnfant() // 4 compris a 12 exclu
        {
            $enfant = new Personne();
            
            $naissance = date('d-m-Y');
            $annee = substr($naissance, 6);
            $annee -= 6;
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            
            $enfant->setDateNaissance($naissance);
            
            $tarifJournee = $enfant->getTarifJournee();
            $tarifDemiJournee = $enfant->getTarifDemiJournee();
            
            $this->assertSame(8, $tarifJournee);
            $this->assertSame(4, $tarifDemiJournee);
        }
        
        public function testGetTarifAdulteReduction() // 12 ou plus, réduction
        {
            $personneReduction = new Personne();
            
            $naissance = date('d-m-Y');
            $annee = substr($naissance, 6);
            $annee -= 20;
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            
            $personneReduction->setDateNaissance($naissance);
            $personneReduction->setReduction(true);
            
            $tarifJournee = $personneReduction->getTarifJournee();
            $tarifDemiJournee = $personneReduction->getTarifDemiJournee();
            
            $this->assertSame(10, $tarifJournee);
            $this->assertSame(5, $tarifDemiJournee);
        }
        
        public function testGetTarifSenior() // 60 ou plus, sans réduction
        {
            $senior = new Personne();
            
            $naissance = date('d-m-Y');
            $annee = substr($naissance, 6);
            $annee -= 70;
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            
            $senior->setDateNaissance($naissance);
            $senior->setReduction(false);
            
            $tarifJournee = $senior->getTarifJournee();
            $tarifDemiJournee = $senior->getTarifDemiJournee();
            
            $this->assertSame(12, $tarifJournee);
            $this->assertSame(6, $tarifDemiJournee);
        }
        
        public function testGetTarifAdulte() // 12 a 59, sans réduction
        {
            $adulte = new Personne();
            
            $naissance = date('d-m-Y');
            $annee = substr($naissance, 6);
            $annee -= 20;
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            
            $adulte->setDateNaissance($naissance);
            $adulte->setReduction(false);
            
            $tarifJournee = $adulte->getTarifJournee();
            $tarifDemiJournee = $adulte->getTarifDemiJournee();
            
            $this->assertSame(16, $tarifJournee);
            $this->assertSame(8, $tarifDemiJournee);
        }
    }