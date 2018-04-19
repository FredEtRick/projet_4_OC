<?php
    namespace OC\finP2Ch1Bundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    
    class ResponseController extends Controller
    {
        public function decomposeAction()
        {
            $response = new Response();
            $response->setContent('erreur 404');
            $response->setStatusCode('Response::HTTP_NOT_FOUND');
            // NE MARCHE PAS !!! Met que reçoit status code a 0
            
            return $response;
        }
        
        public function reponseRapideAction()
        {
            //return $this->get('templating')->renderResponse('OCfinP2Ch1Bundle:response:reponseRapide.html.twig');
            return $this->render('OCfinP2Ch1Bundle:response:reponseRapide.html.twig');
            //return $this->redirectToRoute('oc_fin_p2_ch1_test');
            //return new JsonResponse(array());
        }
    }
?>