<?php
    namespace Test\Fmd\PersonneBundle\Entity;

    use Fmd\PersonneBundle\Entity\Personne;
    use PHPUnit\Framework\TestCase;

    class PersonneTest extends TestCase
    {
        public function testGetTarifJourneeMoins4()
        {
            $enfant = new Personne();
            $enfant->setDateNaissance(new \DateTime('01-10-2016'));
            $enfant->setReduction(false);
            
            $result = $enfant->getTarifJournee();
            
            $this->assertSame(0, $result);
        }
    }