<?php
    namespace OC\DeuxiemeTestBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;

    class MachinController extends Controller
    {
        public function machinAction()
        {
            $content = $this->get('templating')->render('OCDeuxiemeTestBundle:machin:machin.html.twig', array('prenom' => 'frédéric', 'nom' => 'malard'));
            return new Response($content);
        }
    }
?>