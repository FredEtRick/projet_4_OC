<?php
    namespace OC\finP2Ch1Bundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

    class TestController extends Controller
    {
        public function testAction()
        {
            $content = $this->get('templating')->render('OCfinP2Ch1Bundle:test:test.html.twig', array('var1' => 'contenu var1', 'var2' => 'contenu var 2'));
            return new Response($content);
        }
        
        public function viewAction($id)
        {
            /*$content = $this->get('templating')->render('OCfinP2Ch1Bundle:test:view.html.twig', array());
            return new Response($content);*/
            return new Response("valeur de id : " . $id);
        }
        
        public function addAction()
        {
            //$content = $this->get('templating')->render(OCfinP2Ch1Bundle:test:add);
        }
        
        public function parametresMultiplesAction($annee, $nomFichier, $_format)
        {
            $url = $this->get('router')->generate('oc_fin_p2_ch1_view', array('id' => 3));
            $url2 = $this->generateUrl('oc_fin_p2_ch1_test', array(), UrlGeneratorInterface::ABSOLUTE_URL);
            $content = $this->get('templating')->render('OCfinP2Ch1Bundle:test:parametres.html.twig', array('annee' => $annee, 'fichier' => $nomFichier, 'extension' => $_format, 'url' => $url, 'url2' => $url2));
            return new Response($content);
        }
    }
?>