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
            $annee -= 3;
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'naissance : ' . $naissance;
            $naissance = date_create_from_format('d-m-Y', $naissance);
            $bebe->setDateNaissance($naissance);
            $bebe->setReduction(false);
            
            $result = $bebe->getTarifJournee();
            
            $this->assertSame(0, $result);
        }
        
        /*public function testGetTarifJourneeEnfant()
        {
            $enfant = new Personne();
            $enfant->setDateNaissance();
        }*/
    }