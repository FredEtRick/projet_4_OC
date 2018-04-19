<?php
    namespace OC\finP2Ch1Bundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

    class RevisionsController extends Controller
    {
        public function mainAction($titre, $age, Request $request)//, $_format)
        {
            $contenuGet = 'aucun contenu';
            $contenuPost = $contenuGet;
            $ajax = 'non';
            if ($request->isMethod('get'))
                $contenuGet = $request->query->get('contenuGet');
            if ($request->isMethod('post'))
                $contenuPost = $request->request->get('contenuPost');
            if ($request->isXmlHttpRequest())
                $ajax = 'oui';
            $cookie = $request->cookies->get('contenuCookie');
            $requestUri = $request->server->get('REQUEST_URI');
            $userAgent = $request->headers->get('USER_AGENT');
            
            $url = $this->generateUrl('oc_fin_p2_ch1_view', array('id' => 33));
            //$url = $this->get('router')->generate('oc_fin_p2_ch1_view', array('id' => 27, UrlGeneratorInterface::ABSOLUTE_URL));
            
            $content = $this->get('templating')->render('OCfinP2Ch1Bundle:test:revisions.html.twig', array('prénom' => 'frédéric', 'nom' => 'malard', 'titre' => $titre, 'age' => $age, 'url' => $url, 'contenuGet' => $contenuGet, 'contenuPost' => $contenuPost, 'requestUri' => $requestUri, 'userAgent' => $userAgent, 'ajax' => $ajax));//, 'format' => $_format));
            
            return new Response($content);
        }
    }
?>