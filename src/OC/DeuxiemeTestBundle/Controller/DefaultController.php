<?php

namespace OC\DeuxiemeTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCDeuxiemeTestBundle:Default:index.html.twig');
    }
}
