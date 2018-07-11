<?php

namespace Fmd\PersonneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fmd\PersonneBundle\Entity\Personne;
use Fmd\BookingManagementBundle\Entity\Reservation;
use Fmd\BookingManagementBundle\Entity\Billet;

class DefaultController extends Controller
{
    public function getManagerPerso() // pour pouvoir avoir accès aux données depuis autre chose qu'un controleur ! (depuis une entity en l'occurrence, cf le constructeur de reservation qui a besoin de comparer une valeur avec celles de toutes les autres réservations, et impossible d'avoir un manager en dehors d'un controlleur !!!)
    {
        return $this->getDoctrine()->getManager();
    }
    
    public function getRepositoryPersonne()
    {
        return $this->getManagerPerso()->getRepository('FmdPersonneBundle:Personne');
    }
    
    public function getRepositoryReservation()
    {
        return $this->getManagerPerso()->getRepository('FmdBookingManagementBundle:Reservation');
    }
    
    public function getRepositoryBillet()
    {
        return $this->getManagerPerso()->getRepository('FmdBookingManagementBundle:Billet');
    }
    
    public function chercheDoublon($codeAleatoire)
    {
        $repository = $this->getRepositoryReservation();
        return $repository->findOneBy(array('numReservation' => $codeAleatoire));
    }
    
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
    }
}
