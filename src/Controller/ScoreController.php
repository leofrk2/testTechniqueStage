<?php

namespace App\Controller;

use App\Entity\Score;
use App\Form\ScoreType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/score', name: 'score')]
class ScoreController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $scoreRepository = $em->getRepository('App:Score');
        $scores = $scoreRepository->findAll();

        //on affiche les scores dans l'ordre décroissant
        usort($scores, function ($a, $b) {
            return $b->getScore() <=> $a->getScore();
        });
        if(count($scores) == 0){
            return $this->render('Accueil/score.html.twig');
        }
        $args = [
            'scores' => $scores,
        ];
        return $this->render('Accueil/score.html.twig', $args);
    }



}
