<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param $request
     * @param $session
     * @return RedirectResponse
     */
    public function lancerDeAction($idJoueur,  Session $session): Response
    {
        $resultat = rand(1, 6) + rand(1, 6);
        $session->set('resultat'.$idJoueur, $resultat);
        $args = array(
            'resultat' => $resultat,
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
        $idJoueur = $session->get('idJoueur');

        //le joueur a choisi de rejouer
        if($choix == 1) {
            $session->set('choix' . $idJoueur, 1);
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
                $this->inverseIdJoueur($session);
                $session->set("show", 1);
                return $this->render('JeuLocal/tour.html.twig');
            }
        }


        /*$idJoueur = $session->get('idJoueur');
        if($idJoueur == 1) {
            $session->set('idJoueur', 2);
        } else {
            $session->set('idJoueur', 1);
        }

        //si le joueur souhaite rejouer
        if($choix == 1) {
            $session->set('joueur'.$idJoueur.'choix', 1);
        } else if($choix == 0) {
            $session->set('joueur' . $idJoueur . 'finish', 2);
            if($this->checkFin($session)) { //check si la partie est fini -> affiche résultat
                return $this->render('JeuLocal/fin.html.twig');
            }
        }


        //continuer la partie pour le joueur restant qui souhaite lancer ces deux dés
        $session->set('show', 1);
        return $this->render('JeuLocal/tour.html.twig');*/

        /*$idJoueur = $session->get('idJoueur');
        $session->set('joueur'.$idJoueur.'choix', $choix);
        if ($idJoueur == 1){
            $session->set('idJoueur', 2);
        }
        else {
            $session->set('idJoueur', 1);
        }
        echo "joueur1choix : " . $session->get('joueur1choix') . "<br>";
        echo "joueur2choix : " . $session->get('joueur2choix') . "<br>";


            //verification si la partie est terminé
            //partie terminé si les deux joueurs ne souhaitent pas rejouer
            if ($this->checkFin($session)) {
                $idGagnant = $this->checkGagnant($session);
                $args = array(
                    'gagnant' => $idGagnant,
                );
                return $this->render('JeuLocal/fin.html.twig', $args);
            } else { //Si on relance un round
                $session->set('newRound', 1); //TODO qq second avant nouveau round
                $session->set('nbRound', $session->get('nbRound') + 1);
                $args = array(
                    'idJoueur' => $idJoueur,
                );
                if ($this->veuxRejouer($idJoueur, $session)) {
                    $session->set('show', 1);
                    $session->set('replay', 1);
                    return $this->render('JeuLocal/tourRejoue.html.twig', $args);
                } else {
                    $session->set('replay', 0);
                    return $this->render('JeuLocal/tourRejoue.html.twig', $args);
                }
            }*/
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


    public function veuxRejouer($idJoueur, Session $session){
        if($session->get('joueur'.$idJoueur.'choix') == 1)
            return true;
        else
            return false;
    }

    private function checkFin(Session $session)
    {
        //renvoie true si fin de partie
        $joueur1 = $session->get("choix1");
        $joueur2 = $session->get("choix2");
        if($joueur1 == $joueur2 && $joueur1 == 2)
            return true;
        else if($joueur1 == $joueur2 && $joueur1 == 1){
            $this->addFlash('info', 'Les deux joueurs souhaitent relancer leurs dés');
        } else if($joueur1 == 1 && $joueur2 == 2){
            $this->addFlash('info', 'Le joueur 1 souhaite relancer ses dés');
        } else if($joueur1 == 2 && $joueur2 == 1){
            $this->addFlash('info', 'Le joueur 2 souhaite relancer ses dés');
        }
        return false;
    }

    private function checkGagnant(Session $session)
    {
        $resJoueur1 = $session->get('resultat1');
        $resJoueur2 = $session->get('resultat2');
        if($resJoueur1 > $resJoueur2)
            return 1;
        else return 2;
    }


}

