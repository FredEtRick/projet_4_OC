<?php

namespace Fmd\BookingManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Fmd\BookingManagementBundle\Entity;
/*use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;*/

/*$session = new Session();
$session->start();*/

/*$session = new Session(new NativeSessionStorage(), new AttributeBag());
$session->start();*/

use Fmd\PersonneBundle\Entity\Personne;
use Fmd\BookingManagementBundle\Entity\Reservation;
use Fmd\BookingManagementBundle\Entity\Billet;

//require_once '/path/to/vendor/autoload.php';

require_once __DIR__.'/../../../../vendor/autoload.php';

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@FmdBookingManagement/Default/index.php.twig');
    }
    
    public function verifMailAction(Request $request)
    {
        $session = $request->getSession();
        $mailPost = $_POST['mail'];
        $session->set('mail', $mailPost);
        $repository = $this->getDoctrine()->getManager()->getRepository('FmdBookingManagementBundle:Reservation');
        $mailBDD = $repository->findBy(array('mail' => $mailPost));
        if ($mailBDD) // si $mailBDD n'est pas null, c'est que le mail a déjà été utilisé. Préremplir une part du formulaire. Note : passer d'abord par le choix entre "réserver" et "consulter une résevation"
        {
            $session->set('ancienVisiteur', true);
            return $this->render('@FmdBookingManagement/Default/choix.php.twig');
        }
        else // sinon, le mail n'a jamais été utilisé, tout faire de 0.
        {
            $session->set('ancienVisiteur', false);
            $ancienVisiteur = false;
            // echo isset($ancienVisiteur); // affiche 1 pourtant reservation dit que ancienVisiteur existe pas !!!
            return $this->render('@FmdBookingManagement/Default/reservation.php.twig', array('ancienVisiteur' => $ancienVisiteur));
        }
    }
    
    public function choixAction(Request $request)
    {
        $ancienVisiteur = true;
        $choix = $_POST['choix'];
        $session = $request->getSession();
        $mailSession = $session->get('mail');
        if ($choix == 'reserver')
        {
            // préparer les données : précédents visiteurs etc
            // requetes doivent être faites dans repository !!!
            $repository = $this->getDoctrine()->getManager()->getRepository('FmdPersonneBundle:Personne');
            $personnesLieesAuMail = $repository->getPersonnesViaMail($mailSession);
            $session->set("nombrePersonnesLieesAuMail", count($personnesLieesAuMail));
            return $this->render('@FmdBookingManagement/Default/reservation.php.twig', array('ancienVisiteur' => $ancienVisiteur, 'personnesLieesAuMail' => $personnesLieesAuMail));
        }
        elseif ($choix == 'consulter')
        {
            $repositoryReservation = $this->getDoctrine()->getManager()->getRepository('FmdBookingManagementBundle:Reservation');
            $reservationsLieesAuMail = $repositoryReservation->getReservationsViaMail($mailSession);
            $session->set("nombreReservationsLieesAuMail", count($reservationsLieesAuMail));
            return $this->render('@FmdBookingManagement/Default/consultation.php.twig', array('reservationsLieesAuMail' => $reservationsLieesAuMail, 'mail' => $mailSession));
        }
        else
        {
            return $this->render('@FmdBookingManagement/Default/index.php.twig');
            // rajouter un message d'erreur
        }
    }

    public function paiementAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('post', $_POST);

        if ($_POST['demiJournee'] == "non")
            $demiJournee = false;
        else
            $demiJournee = true;
        $nombrePersonnesLieesAuMail = $session->get("nombrePersonnesLieesAuMail");
        $prix = 0;

        $ancienVisiteur = $session->get('ancienVisiteur');
        $date = \DateTime::createFromFormat('d/m/Y', $_POST['dateVisite']);
        $nombrePersonnesLieesAuMail = $session->get("nombrePersonnesLieesAuMail");
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository('FmdPersonneBundle:Personne');

        // creer la reservation en BDD
        $reservation = new Reservation();
        $reservation->setDateReservation($date);
        $reservation->setDemiJournee($demiJournee);

        // ajout des anciens visiteurs conservés
        for ($i=1 ; $i <= $nombrePersonnesLieesAuMail ; $i++)
        {
            if (isset($_POST["idPersonne" . $i]))
            {
                // persister billets qui pointent vers la réservation courante et vers l'id de chaque personne.
                $billet = new Billet();
                $personne = $repository->find($_POST["idPersonne" . $i]);
                $billet->setPersonne($personne);
                $billet->setReservation($reservation);
                $prix += $billet->getTarif();
                //echo $billet->getTarif();
            }
        }

        // ajout des nouveaux visiteurs
        $indexDernierePersonne = $_POST['indexDernierePersonne'];
        for ($i=1 ; $i<=$indexDernierePersonne ; $i++)
        {
            if (isset($_POST['prenom' . $i])) // si l'une des caractéristiques d'un visiteur existe c'est que le visiteur existe. Doit faire cette vérification car on peut supprimer des visiteurs donc entre le visiteur 1 et le dernier il y a peut être des trous dans le compte
            {
                // création personnes
                $visiteur = new Personne();
                $dateNaissance = \DateTime::createFromFormat('d/m/Y', $_POST['dateNaissance' . $i]);
                $visiteur->setDateNaissance($dateNaissance);
                if (isset($_POST['reduction' . $i])) // si pas checkboxcochée, pas définie
                    $visiteur->setReduction(1);
                else
                    $visiteur->setReduction(0);

                // création du billet
                $billet = new Billet();
                $billet->setPersonne($visiteur);
                $billet->setReservation($reservation);
                $prix += $billet->getTarif();
                //echo $billet->getTarif();
            }
        }

        $session->set('prix', $prix);

        return $this->render('@FmdBookingManagement/Default/paiement.php.twig', array('prix' => $prix*100));
    }

    public function traitementAction(Request $request)
    {
        // print_r($_POST); // debug

        // d'abord essayer d'effectuer le paiement, et ensuite, si paiement réussi, faire la suite ?

        \Stripe\Stripe::setApiKey("sk_test_AssWuckpnHlwx6B4edglOnpj");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $session = $request->getSession();
        $prix = $session->get('prix');

        $charge = \Stripe\Charge::create([
            'amount' => $prix*100,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);


        $POST = $session->get('post');
        $mail = $session->get('mail');
        $sujetMail = 'Votre réservation pour le musée du Louvre';
        $ancienVisiteur = $session->get('ancienVisiteur');
        $date = \DateTime::createFromFormat('d/m/Y', $POST['dateVisite']);
        $demiJournee = $POST['demiJournee'];
        if ($POST['demiJournee'] == "non")
            $demiJournee = false;
        else
            $demiJournee = true;
        $nombrePersonnesLieesAuMail = $session->get("nombrePersonnesLieesAuMail");
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository('FmdPersonneBundle:Personne');
        //if (preg_match("#^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}#", $mail))
        if (preg_match("#(hotmail|live|msn)\.[a-zA-Z]{2,6}$#", $mail))
            $sautLigne = "\r\n";
        else
            $sautLigne = "\n";
        $personnesPourMail = array();
        //$cheminImage = __DIR__.'"/../../../../web/images/musee.jpg"';
        
        /*$messageMail = '';
        $messageHtml = '<html><head><title>musée du Louvre</title></head><body>';
        $messageTexte = '';*/

        // creer la reservation en BDD
        $reservation = new Reservation();
        $reservation->setMail($mail);
        $reservation->setDateReservation($date);
        $reservation->setDemiJournee($demiJournee);
        $em->persist($reservation);

        //echo '<p>' . $_SERVER['PHP_SELF'] . '</p>';

        /*$messageHtml .= '<p>Musée du Louvre.<br /><img src="cid:images/musee.jpg" alt="louvre" /></p>';
        $messageHtml .= '<p>Billet pour une visite le ';*/
        $dateReservationString = $reservation->getDateReservationString();
        /*if ($demiJournee)
            $messageHtml .= ' après 14h.';
        else
            $messageHtml .= ', heure d\'arrivée libre.';
        $messageHtml .= '</p><p>Personnes attendues :<br />';

        $messageTexte .= 'Musée du Louvre.' . $sautLigne;
        $messageTexte .= 'Billet pour une visite le ';
        $messageTexte .= $reservation->getDateReservationString();
        if ($demiJournee)
            $messageTexte .= ' après 14h.';
        else
            $messageTexte .= ', heure d\'arrivée libre.';
        $messageTexte .= $sautLigne . $sautLigne . 'Personnes attendues :' . $sautLigne;*/

        // ajout des anciens visiteurs conservés
        for ($i=1 ; $i <= $nombrePersonnesLieesAuMail ; $i++)
        {
            if (isset($POST["idPersonne" . $i]))
            {
                // persister billets qui pointent vers la réservation courante et vers l'id de chaque personne.
                $billet = new Billet();
                $personne = $repository->find($POST["idPersonne" . $i]);
                $billet->setPersonne($personne);
                $billet->setReservation($reservation);
                $em->persist($billet);
                if ($personne->getReduction())
                    $reductionString = 'oui';
                else
                    $reductionString = 'non';
                $personnesPourMail[] = $personne->getPrenom() . ' ' . $personne->getNom() . ', né le ' . $personne->getDateNaissanceString() . ', réduction : ' . $reductionString;
                /*$messageHtml .= $ajoutMessage . '<br />';
                $messageTexte .= $ajoutMessage . $sautLigne;*/
            }
        }

        // ajout des nouveaux visiteurs
        $indexDernierePersonne = $POST['indexDernierePersonne'];
        for ($i=1 ; $i<=$indexDernierePersonne ; $i++)
        {
            if (isset($POST['prenom' . $i])) // si l'une des caractéristiques d'un visiteur existe c'est que le visiteur existe. Doit faire cette vérification car on peut supprimer des visiteurs donc entre le visiteur 1 et le dernier il y a peut être des trous dans le compte
            {
                // création personnes
                $visiteur = new Personne();
                $visiteur->setPrenom($POST['prenom' . $i]);
                $visiteur->setNom($POST['nom' . $i]);
                $visiteur->setPays($POST['pays' . $i]);
                $dateNaissance = \DateTime::createFromFormat('d/m/Y', $POST['dateNaissance' . $i]);
                $visiteur->setDateNaissance($dateNaissance);
                if (isset($POST['reduction' . $i])) // si pas checkboxcochée, pas définie
                {
                    $visiteur->setReduction(1);
                    $reductionString = 'oui';
                }
                else
                {
                    $visiteur->setReduction(0);
                    $reductionString = 'non';
                }

                $personnesPourMail[] = $visiteur->getPrenom() . ' ' . $visiteur->getNom() . ', né le ' . $visiteur->getDateNaissanceString() . ', réduction : ' . $reductionString;
                /*$messageHtml .= $ajoutMessage . '<br />';
                $messageTexte .= $ajoutMessage . $sautLigne;*/
                
                // NOTE CETTE PERSONNE PEUT DEJA EXISTER DANS UNE AUTRE RESERVATION, TRAITER LE CAS !!!

                $visiteurBdd = $repository->findOneBy(array(
                    'prenom' => $visiteur->getPrenom(),
                    'nom' => $visiteur->getNom(),
                    'pays' => $visiteur->getPays(),
                    'dateNaissance' => $visiteur->getDateNaissance(),
                    'reduction' => $visiteur->getReduction()
                ));

                if ($visiteurBdd == null)
                {
                    // persister la personne dans la BDD
                    $em->persist($visiteur);
                }

                // création du billet
                $billet = new Billet();
                if ($visiteurBdd == null)
                    $billet->setPersonne($visiteur);
                else
                    $billet->setPersonne($visiteurBdd);
                $billet->setReservation($reservation);

                // persister les billet qui font les liens
                $em->persist($billet);
            }
        }

        /*$messageHtml .= '</p><p>Tarif : ' . $prix . '€.<br />';
        $messageHtml .= 'code de réservation : ' . $reservation->getId() . '*' . $reservation->getAleatoire() . '</p>';

        $messageHtml .= '<p>Cet e-mail fait office de billet. Vous pouvez l\'imprimerou le montrer sur votre smartphone ou tablette.</p></body></html>';

        $messageTexte .= $sautLigne . 'Tarif : ' . $prix . '€.' . $sautLigne;
        $messageTexte .= 'code de réservation : ' . $reservation->getId() . '*' . $reservation->getAleatoire() . $sautLigne . $sautLigne;

        $messageTexte .= 'Cet e-mail fait office de billet. Vous pouvez l\'imprimerou le montrer sur votre smartphone ou tablette.';



        $headers[] = 'From: "travail"<travail@MacBook-Pro-de-frederic.local>';
        $headers[] = 'Reply-to: "frederic malard"<fred.malard@gmx.fr>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: multiple/alternative';
        $boundary = '-----=' . md5(rand());
        $headers[] = 'boundary=' . $boundary;

        $messageMail .= $sautLigne . '--' . $boundary . $sautLigne;
        $messageMail .= 'Content-Type: text/html; charset="iso-8859-1"' . $sautLigne;
        $messageMail .= 'Content-transer-encoging: 8bit' . $sautLigne;
        $messageMail .= $messageHtml . $sautLigne;

        $messageMail .= $sautLigne . '--' . $boundary . $sautLigne;
        $messageMail .= 'Content-Type: text/plain; charset="iso-8859-1"' . $sautLigne;
        $messageMail .= 'Content-transfer-encoding: 8bit' . $sautLigne;
        $messageMail .= $messageTexte . $sautLigne;
        $messageMail .= $sautLigne . '--' . $boundary . $sautLigne;
        $messageMail .= $sautLigne . '--' . $boundary . $sautLigne;

        mail($destinataire, $sujet, $message, implode($sautLigne, $headers));




        /*$headers[] = 'MIME-Version: 1.0';
        //$headers[] = 'Content-type: text/html; charset=utf-8';
        //$headers[] = "Content-Type: multipart/alternative; charset=utf-8"
        $headers[] = 'Content-type:text/html; charset="ISO-8895-1"';
        $headers[] = 'Content-transfer-Encoding : 8bit';
        // $headers[] = "boundary=\"$boundary\""; je sais même pas ce que c'est $boundary, c'est même pas déclaré !!!

        $headers[] = 'To: ' . $mail;
        $headers[] = 'From: \"travail\"<travail@MacBook-Pro-de-frederic.local>';
        $headers[] = "Reply-to: \"fred\"<fred.mgm2@gmail.com>"
        /*$headers[] = 'Cc: anniversaire_archive@example.com';
        $headers[] = 'Bcc: anniversaire_verif@example.com';*/

        /*$headers[] = "Content-Type: application/octet-stream;name=\"logo_lm.jpg\"";
        $headers .="Content-Transfer-Encoding: base64";
        $headers .="Content-Disposition = attachment; filename=logo_lm.jpg";*/





        $reussi = ($charge->status == "succeeded");

        if ($reussi)
        {
            $em->flush();
            $em->refresh($reservation); // pour récupérer l'id
            //var_dump(mail ($mail, $sujetMail, $messageMail, implode ("\n", $headers)));

            $codeReservation = $reservation->getId() . '*' . $reservation->getAleatoire();

            $mailFinal = (new \Swift_Message($sujetMail))
                ->setFrom('travail@MacBook-Pro-de-frederic.local')
                ->setTo($mail)
                ->setCharset('UTF-8')
                ->setBody($this->renderView('@FmdBookingManagement/Default/mail.php.twig', array('dateReservationString' => $dateReservationString, 'demiJournee' => $demiJournee, 'personnesPourMail' => $personnesPourMail, 'prix' => $prix, 'codeReservation' => $codeReservation)), 'text/html');

            $this->get('mailer')->send($mailFinal);
        }

        return $this->render('@FmdBookingManagement/Default/traitement.php.twig', array('reussi' => $reussi));
    }
}
