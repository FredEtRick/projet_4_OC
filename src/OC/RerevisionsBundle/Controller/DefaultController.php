<?php

namespace OC\RerevisionsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $paramPost = '';
        $paramGet = $request->query->get('viaUrl');
        if ($request->query->get('bit') != null)
            $bit = $request->query->get('bit');
        if ($request->isMethod('post'))
            $paramPost = $request->request->get('viaFormulaire');
        //$paramCookie = $request->cookies->get('dateInscription');
        $paramServer = $request->server->get('REQUEST_URI');
        $paramServerHttp = $request->headers->get('USER_AGENT');
        $ajax = 'non';
        if ($request->isXmlHttpRequest())
            $ajax = 'oui';
        $moi = array('prenom' => 'frédéric', 'nom' => 'malard', 'age' => 27);
        $parametres = array('url' => $paramGet, 'formulaire' => $paramPost, 'uri' => $paramServer, 'serverHttp' => $paramServerHttp, 'ajax' => $ajax, 'moi' => $moi);
        if ($request->query->get('bit') != null)
            $parametres['bit'] = $bit;
        
        return $this->render('OCRerevisionsBundle:Default:index.html.twig', $parametres);
    }
}
