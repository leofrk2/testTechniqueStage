<?php

namespace App\Controller;

use App\Entity\Score;
use App\Form\ConnexionType;
use App\Form\ScoreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/*
 * Ce controller gère l'affichage des scores
 */

#[Route('/score', name: 'score')]
class ScoreController extends AbstractController
{
    #[Route('/list', name: '_list')]
    // Affiche la liste des scores
    public function listAction(ManagerRegistry $doctrine, Session $session): Response
    {
        $session->set('formConnexionVisible', false);
        return $this->getScores($doctrine, $session);
    }

    #[Route('/add', name: '_add')]
    // Ajoute un score
    public function addAction(ManagerRegistry $doctrine, Session $session): Response
    {

        $score = new Score();
            $score->setScore($session->get('resFinal'));
            $score->setPseudo($session->get('vainqueur'));
            $em = $doctrine->getManager();
            $em->persist($score);
            $em->flush();
            $this->addFlash('success', 'Score ajouté');
            return $this->redirectToRoute('score_list');
    }

    #[Route('/connexion', name: '_connexion')]
    // Affiche le formulaire de connexion
    public function connexionAction(Request $request, Session $session, ManagerRegistry $doctrine): Response
    {
        $password = $request->get('password');
        if(sha1($password) == "d033e22ae348aeb5660fc2140aec35850c4da997"){ //mot de passe : "admin"
            $session->set('isAuth', true);
            $this->addFlash('info', 'Vous êtes connecté en tant qu\'admin');
        }

        $session->set('formConnexionVisible', true);
        return $this->getScores($doctrine, $session);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param Session $session
     * @return Response
     */
    // Récupère les scores trié
    public function getScores(ManagerRegistry $doctrine, Session $session): Response
    {
        $em = $doctrine->getManager();
        $scoreRepository = $em->getRepository('App:Score');
        $scores = $scoreRepository->findAll();

        //on affiche les scores dans l'ordre décroissant
        usort($scores, function ($a, $b) {
            return $b->getScore() <=> $a->getScore();
        });
        if (count($scores) == 0) {
            return $this->render('Accueil/score.html.twig');
        }
        $args = [
            'scores' => $scores,
        ];
        return $this->render('Accueil/score.html.twig', $args);
    }

    #[Route('/vider', name: '_vider')]
    // Vide la table score
    public function viderAction(ManagerRegistry $doctrine, Session $session): Response
    {
        $em = $doctrine->getManager();
        $scoreRepository = $em->getRepository('App:Score');
        $scores = $scoreRepository->findAll();
        foreach ($scores as $score) {
            $em->remove($score);
        }
        $em->flush();
        $this->addFlash('info', 'Score supprimé');
        return $this->redirectToRoute('score_list');
    }

    #[Route('/deconnexion', name: '_deconnexion')]
    // Déconnecte l'utilisateur
    public function deconnexionAction(Session $session): Response
    {
        $session->set('isAuth', false);
        $this->addFlash('info', 'Vous êtes déconnecté');
        return $this->redirectToRoute('score_list');
    }


}
