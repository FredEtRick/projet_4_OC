<?php
    namespace OC\RerevisionsBundle\Controller;
    
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
    use Symfony\Comonent\HttpFoundation\RedirectResponse;
    
    class RerevisionsController extends Controller
    {
        public function rerevisionsAction($annee, $fichier, $_format, Request $request)
        {
            $getProtegee = $request->query->get('getProtegee');
            $getNonProtegee = $request->query->get('getNonProtegee');
            $getRaw = $request->query->get('getRaw');
            $url = $this->get('router')->generate('oc_fin_p2_ch1_test', array(), UrlGeneratorInterface::ABSOLUTE_URL);
            $url2 = $this->generateUrl('oc_fin_p2_ch1_test');
            $content = $this->get('templating')->render('OCRerevisionsBundle:Rerevisions:rerevisions.html.twig', array('annee' => $annee, 'fichier' => $fichier, 'extension' => $_format, 'url' => $url, 'url2' => $url2, 'getProtegee' => $getProtegee, 'getNonProtegee' => $getNonProtegee, 'getRaw' => $getRaw));
            return new Response($content);
        }
        public function decomposeAction()
        {
            $response = new Response();
            $response->setContent("erreur 404");
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            return $response;
        }
        public function reponseRapideAction()
        {
            //return $this->get('templating')->renderResponse('OCRerevisionsBundle:Rerevisions:reponseRapide.html.twig');
            return $this->render('OCRerevisionsBundle:Rerevisions:reponseRapide.html.twig');
        }
        public function redirectionAction()
        {
            return $this->redirectToRoute('oc_rerevisions_reponseRapide');
            // return new JsonResponse(array('id' => $id));
        }
        public function sessionAction(Request $request)
        {
            $session = $request->getSession();
            $session->set('id', 14);
            return new Response($session->get('id'));
        }
        public function flashSessionAction(Request $request)
        {
            $session = $request->getSession();
            $session->getFlashBag()->add('personnes', 'Jean-Luc');
            $session->getFlashBag()->add('personnes', 'Sarah');
            return $this->redirectToRoute('oc_rerevisions_rerevisions');
        }
        public function mailAction()
        {
            $contenu = $this->renderView('OCRerevisionsBundle:Rerevisions:mail.txt.twig', array('var' => 'iohoiho'));
            mail('fred.malard@wanadoo.fr', 'mailViaSymfony', $contenu);
            return new Response('tentative d\'envoie de mail a ma propre adresse.');
        }
        public function heritageAction()
        {
            return $this->render('OCRerevisionsBundle:Rerevisions:fils.html.twig');
        }
        public function pourInclusionAction()
        {
            return $this->render('OCRerevisionsBundle:Rerevisions:aInclureViaController.html.twig', array('nomMethode' => 'pourInclusionAction'));
        }
    }
?>