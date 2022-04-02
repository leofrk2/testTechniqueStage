<?php

namespace App\Controller;

use App\Entity\Score;
use App\Form\ScoreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/jeuLocal', name: 'jeu_local')]
class JeuLocalController extends AbstractController
{
    #[Route('/index', name: '_index')]
    public function indexAction(): Response
    {
        return $this->render('JeuLocal/index.html.twig');
    }

    #[Route('/nouvellePartie', name: '_nouvelle_partie')]
    public function nouvellePartieAction(Session $session): Response
    {
        // on init avec 1 pour le moment TODO
        $session->set('joueur1choix', 1);
        $session->set('joueur1choix', 1);
        $session->set('choix1', 0);
        $session->set('choix2', 0);

        $session->set('idJoueur', 1);
        $session->set('new' , 1);
        $session->set('nbRound', 1);
        $session->set('show', 1);
        return $this->render('JeuLocal/tour.html.twig');
    }

    /**
     * @Route("/lancer/{idJoueur}", name="_lancer")
     * @param $idJoueur
     * @param Session $session
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function lancerDeAction($idJoueur,  Session $session, Request $request, EntityManagerInterface $em): Response
    {
        $resultat = rand(1, 6) + rand(1, 6);
        if($resultat > 1){
            if($idJoueur == 1){
                $tmp = 2;
            }else{
                $tmp = 1;
            }

            //echo a javascript to open a popup

           /* echo "<script>
            alert('Vous avez perdu !');
</script>";*/

             $score = new Score();
             $form = $this->createForm(ScoreType::class, $score);
             $form->handleRequest($request);
             if($form->isSubmitted() && $form->isValid()) {
                 $score = $form->getData();
                 $em->persist($score);
                 $em->flush();
                 $this->addFlash('success', 'Score enregistré');
             }

            $args = array (
                "Form" => $form->createView(),
                "loose" => 1,
                "gagnant" => $tmp,
            );

            return $this->render('JeuLocal/fin.html.twig', $args);
        }

        $session->set('resultat'.$idJoueur, $resultat);
        $args = array(
            'resultat' => $resultat,
            'loose' => 0
        );
        return $this->render('JeuLocal/tour.html.twig', $args);
    }

    /**
     * @Route("/choix/{choix}", name="_choix")
     * @param $choix
     * @param $session
     * @return RedirectResponse
     */
    public function choixejouer($choix, Session $session) : Response
    {
        //TODO round++ si rejoue
        $idJoueur = $session->get('idJoueur');

        //le joueur a choisi de rejouer
        if($choix == 1) {
            $session->set('choix' . $idJoueur, 1);

            if($idJoueur == 1)
                $tmp = 2;
            else
                $tmp = 1;

            if($session->get('choix' . $tmp) == 2) { // cas ou un seul rejoue
                $session->set('nbRound', $session->get('nbRound') + 1);
                $session->set('show', 1);
                return $this->render('JeuLocal/tour.html.twig');
            }

            if($idJoueur == 2)
                $session->set('nbRound', $session->get('nbRound') + 1);

            $session->set('show', 1);
            $this->inverseIdJoueur($session);
            return $this->render('JeuLocal/tour.html.twig');


        } else { //Le joueur ne rejoue pas
            $session->set('choix' . $idJoueur, 2);
            if($this->checkFin($session)) {
                $idGagnant = $this->checkGagnant($session);
                $args = array(
                    'gagnant' => $idGagnant,
                );
                return $this->render('JeuLocal/fin.html.twig', $args);
            } else {
                $session->set("show", 1);
                $this->inverseIdJoueur($session);
                return $this->render('JeuLocal/tour.html.twig');
            }
        }


    }

    //write a private function to pass idJoueur to 2 if 1 and vice versa
    private function inverseIdJoueur(Session $session){
        $idJoueur = $session->get('idJoueur');
        if($idJoueur == 1) {
            $session->set('idJoueur', 2);
        } else {
            $session->set('idJoueur', 1);
        }
    }

    private function checkFin(Session $session)
    {
        //renvoie true si fin de partie
        $joueur1 = $session->get("choix1");
        $joueur2 = $session->get("choix2");
        if($joueur1 == $joueur2 && $joueur1 == 2)
            return true;
        else
            return false;
    }

    private function checkGagnant(Session $session)
    {
        $resJoueur1 = $session->get('resultat1');
        $resJoueur2 = $session->get('resultat2');

        //si un joueur a + de 9 il a automatiquement perdu
        if ($resJoueur1 > $resJoueur2)
            return 1;
        else
            return 2;
    }
}

