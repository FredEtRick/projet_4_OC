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
        return $this->render('@FmdPersonne/Default/index.php.twig');
    }
}




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
        
        
        
        /*$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FmdPersonneBundle:Personne');
        
        $QuelQuun = $repository->find(31);
        $UnotpHerson = $repository->find(32);
        $HankHorunotpHerson = $repository->find(33);
        
        $reservation = new Reservation();
        
        $billetQuelQuun = new Billet();
        $billetUnotpHerson = new Billet();
        $billetHankHorunotpHerson = new Billet();
        
        $billetQuelQuun->setPersonne($QuelQuun);
        $billetQuelQuun->setJourneeEntiere(false);
        $billetQuelQuun->setReservation($reservation);
        
        $billetUnotpHerson->setPersonne($UnotpHerson);
        $billetUnotpHerson->setJourneeEntiere(false);
        $billetUnotpHerson->setReservation($reservation);
        
        $billetHankHorunotpHerson->setPersonne($HankHorunotpHerson);
        $billetHankHorunotpHerson->setJourneeEntiere(false);
        $billetHankHorunotpHerson->setReservation($reservation);
        
        $billets = array($billetQuelQuun, $billetUnotpHerson, $billetHankHorunotpHerson);
        
        $reservation->setMail('quelquun@sfr.fr');
        $reservation->setBillets($billets);
        $reservation->setDateReservation(new \DateTime('2018-07-30'));
        
        $em->persist($reservation);
        $em->persist($billetQuelQuun);
        $em->persist($billetUnotpHerson);
        $em->persist($billetHankHorunotpHerson);
        
        $em->flush();
        
        return $this->render('@FmdPersonne/Default/index.html.twig');*/