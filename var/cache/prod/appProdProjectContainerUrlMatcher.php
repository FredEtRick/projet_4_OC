<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        // fmd_booking_management_homepage
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'Fmd\\BookingManagementBundle\\Controller\\DefaultController::indexAction',  '_route' => 'fmd_booking_management_homepage',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_fmd_booking_management_homepage;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fmd_booking_management_homepage'));
            }

            return $ret;
        }
        not_fmd_booking_management_homepage:

        // fmd_personne_homepage
        if ('/personne' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'Fmd\\PersonneBundle\\Controller\\DefaultController::indexAction',  '_route' => 'fmd_personne_homepage',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_fmd_personne_homepage;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fmd_personne_homepage'));
            }

            return $ret;
        }
        not_fmd_personne_homepage:

        // homepage
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_homepage;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'homepage'));
            }

            return $ret;
        }
        not_homepage:

        if ('/' === $pathinfo && !$allow) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
