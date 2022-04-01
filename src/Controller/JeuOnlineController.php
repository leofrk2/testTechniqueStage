<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/JeuOnline', name: 'jeu_online')]
class JeuOnlineController extends AbstractController
{


    #[Route('/index', name: '_index')]
    public function indexAction(): Response
    {
        return $this->render("JeuOnline/index.html.twig");
    }

}
