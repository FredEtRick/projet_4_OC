<?php
    namespace Test\Fmd\PersonneBundle\Entity;

    use Fmd\PersonneBundle\Entity\Personne;
    use PHPUnit\Framework\TestCase;

    class PersonneTest extends TestCase
    {
        public function testGetTarifJourneeMoins4()
        {
            $bebe = new Personne();
            $aujourdhui = date('d-m-Y');
            $jour = substr($aujourdhui, 0, 2);
            $mois = substr($aujourdhui, 3, 2);
            $annee = substr($aujourdhui, 6);
            $annee -= 4;
            if ($jour > 1)
                $jour--;
            // TROMPE !!! IL FAUT AJOUTER UN JOUR PAS LE RETIRER.
            elseif ($jour == 1 && mois > 1)
            {
                $m30 = array(4, 6, 9, 11);
                $m31 = array(3, 5, 7, 8, 10, 12);
                if (($mois - 1) == 2)
                {
                    
                }
                if (in_array(($mois - 1), $m30))
                    $jour = 30;
                if (in_array(($mois - 1), $m31))
                    $jour = 31;
                $mois--;
            }
            $naissance = substr($naissance, 0, 6) . $annee;
            echo 'NAISSANCE : ' . $naissance;
            $bebe->setDateNaissance(new \DateTime('01-10-2016'));
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