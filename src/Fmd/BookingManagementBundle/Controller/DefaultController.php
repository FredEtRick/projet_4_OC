<?php

namespace Fmd\BookingManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FmdBookingManagementBundle:Default:index.html.twig');
    }
}
