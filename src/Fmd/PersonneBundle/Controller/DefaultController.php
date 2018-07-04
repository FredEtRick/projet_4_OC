<?php

namespace Fmd\PersonneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fmd\PersonneBundle\Entity\Personne;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $personne = new Personne();
        
        $personne->setPrenom('Frederic');
        $personne->setNom('Malard');
        $personne->setPays('France');
        $personne->setDateNaissance(new \Datetime('06-03-1991'));
        $personne->setReduction(false);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($personne);
        $em->flush();
        
        $dateNaissance = $personne->getDateNaissance();
        $tarif = $personne->getTarifJournee();
        
        return $this->render('FmdPersonneBundle:Default:index.html.twig', array('dateNaissance' => date_format($dateNaissance, 'd/m/Y'), 'tarif' => $tarif));
    }
}
