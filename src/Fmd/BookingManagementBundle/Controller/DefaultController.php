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
        if ($choix == 'reserver')
        {
            $session = $request->getSession();
            $mailSession = $session->get('mail');
            // préparer les données : précédents visiteurs etc
            // requetes doivent être faites dans repository !!!
            $repository = $this->getDoctrine()->getManager()->getRepository('FmdPersonneBundle:Personne');
            $personnesLieesAuMail = $repository->getPersonnesViaMail($mailSession);
            $session->set("nombrePersonnesLieesAuMail", count($personnesLieesAuMail));

            return $this->render('@FmdBookingManagement/Default/reservation.php.twig', array('ancienVisiteur' => $ancienVisiteur, 'personnesLieesAuMail' => $personnesLieesAuMail));
        }
        elseif ($choix == 'consulter')
        {
            return $this->render('@FmdBookingManagement/Default/consultation.php.twig');
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
                echo $billet->getTarif();
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
                echo $billet->getTarif();
            }
        }

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

        $charge = \Stripe\Charge::create([
            'amount' => 999,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
        ]);


        $session = $request->getSession();
        $POST = $session->get('post');
        $mail = $session->get('mail');
        $ancienVisiteur = $session->get('ancienVisiteur');
        $date = \DateTime::createFromFormat('d/m/Y', $POST['dateVisite']);
        $demiJournee = $POST['demiJournee'];
        if ($_POST['demiJournee'] == "non")
            $demiJournee = false;
        else
            $demiJournee = true;
        $nombrePersonnesLieesAuMail = $session->get("nombrePersonnesLieesAuMail");
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository('FmdPersonneBundle:Personne');

        // creer la reservation en BDD
        $reservation = new Reservation();
        $reservation->setMail($mail);
        $reservation->setDateReservation($date);
        $reservation->setDemiJournee($demiJournee);
        $em->persist($reservation);

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
                    $visiteur->setReduction(1);
                else
                    $visiteur->setReduction(0);
                
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

        $em->flush();

        $reussi = ($charge->status == "succeeded");

        return $this->render('@FmdBookingManagement/Default/traitement.php.twig', array('reussi' => $reussi));
    }
}
