<?php

namespace App\Controller;

use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/score', name: 'score')]
class ScoreController extends AbstractController
{
/*    #[Route('/score', name: 'app_score')]
    public function addScoreAction(EntityManagerInterface $em): Response
    {
        $score = new Score();
        $scoreRepo = $em->getRepository('App:Score', $score);


        $this->addFlash('success', 'Score added!');
        return $this->render("Accueil/accueil.html.twig");
    }*/
}
