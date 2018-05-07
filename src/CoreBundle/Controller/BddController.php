<?php
    namespace CoreBundle\Controller;
    
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use CoreBundle\Entity\Prof;

    class BddController extends Controller
    {
        public function bddAction()
        {
            $prof = new Prof();
            $prof->setNomProf("MrProf");
            $prof->setMatiereProf("Maths");
            $em = $this->getDoctrine()->getManager();
            $em->persist($prof);
            $prof1 = $em->getRepository("CoreBundle:Prof")->find(1);
            $nomProf1 = $prof1->getNomProf();
            $prof1->setNomProf($nomProf1 . " !");
            //$em->detach($prof1);
            $em->refresh($prof1);
            //$prof5 = $em->getRepository("CoreBundle:Prof")->find(5);
            //$em->remove($prof5);
            $em->flush();
            $reponse = $em->getRepository("CoreBundle:Prof")->find(1)->getNumProf();
            $reponse .= " Entité MrProf enregistrée. ";
            if ($em->contains($prof))
                $reponse .= "Contient prof. ";
            if ($em->contains($prof1))
                $response .= "Contient prof1. ";
            return new Response($reponse);
        }
    }
?>