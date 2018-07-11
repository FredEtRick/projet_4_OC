<?php

namespace Fmd\PersonneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fmd\PersonneBundle\Entity\Personne;
use Fmd\BookingManagementBundle\Entity\Reservation;
use Fmd\BookingManagementBundle\Entity\Billet;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /*$personne = new Personne();
        
        $personne->setPrenom('Hon');
        $personne->setNom('Zen');
        $personne->setPays('France');
        $personne->setDateNaissance(new \Datetime('20-01-2007'));
        $personne->setReduction(false);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($personne);
        $em->flush();
        
        $dateNaissance = $personne->getDateNaissance();
        $tarif = $personne->getTarifJournee();
        
        return $this->render('@FmdPersonne/Default/index.html.twig', array('dateNaissance' => date_format($dateNaissance, 'd/m/Y'), 'tarif' => $tarif));*/
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FmdPersonneBundle:Personne');
        
        $frederic = $repository->find(1);
        $machin = $repository->find(30);
        
        $reservation = new Reservation();
        
        $billetFrederic = new Billet();
        $billetMachin = new Billet();
        
        $billetFrederic->setPersonne($frederic);
        $billetFrederic->setJourneeEntiere(true);
        $billetFrederic->setReservation($reservation);
        
        $billetMachin->setPersonne($machin);
        $billetMachin->setJourneeEntiere(true);
        $billetMachin->setReservation($reservation);
        
        $billets = array($billetFrederic, $billetMachin);
        
        $reservation->setMail('fred.malard@wanadoo.fr');
        $reservation->setBillets($billets);
        $reservation->setDateReservation(new \DateTime('2018-08-10'));
        
        $em->persist($reservation);
        $em->persist($billetFrederic);
        $em->persist($billetMachin);
        
        $em->flush();
        
        return $this->render('@FmdPersonne/Default/index.html.twig');
    }
}
