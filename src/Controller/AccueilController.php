<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'accueil')]
class AccueilController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function indexAction(): Response
    {
        return $this->render("Accueil/Accueil.html.twig");
    }
}
