<?php
    namespace OC\finP2Ch1Bundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    //use Symfony\Component\HttpFoundation\Session\session;
    
    class SessionController extends Controller
    {
        public function sessionAction(Request $request)
        {
            /*$sessionAvant = $request->getSession()->get('machin');
            $request->setSession()->set('machin', 17);
            $sessionApres = $request->getSession()->get('machin');
            
            $session = $request->getSession();
            $session->getFlashBag()->add('nomGroupe', 'valeur première');
            $session->getFlashBag()->add('nomGroupe', 'une seconde valeur !');
            
            return $this->redirectToRoute('oc_fin_p2_ch1_test');*/
            
            $request->getSession->getFlashBag()->add('nomGroupe', 'valeur première');
            $request->getFlashBag()->add('nomGroupe', 'deuxième valeur !');
            
            return $this->redirectRoute('oc_fin_p2_ch1_test');
        }
    }
?>