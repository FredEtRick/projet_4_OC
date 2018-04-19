<?php

namespace OC\finP2Ch1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('OCfinP2Ch1Bundle:Default:index.html.twig', array('prénom' => 'frédéric', 'nom' => 'malard'));
        return new Response($content);
    }
}
