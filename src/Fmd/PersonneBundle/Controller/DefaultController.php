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
        //$personne->setDateNaissance(new \Date('03-06-1991')); PROBLEME DATE !!! Dit que manque un use mais je trouve pas chemin
        $personne->setReduction(false);
        
        /*$em = $this->getDoctrine()->getManager();
        $em->persist($personne);
        $em->flush();
        
        $dateNaissance = $personne->getDateNaissance();*/
        
        return $this->render('FmdPersonneBundle:Default:index.html.twig'/*, array('dateNaissance' => $dateNaissance)*/);
    }
}
