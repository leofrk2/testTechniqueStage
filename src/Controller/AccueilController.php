<?php

namespace App\Controller;

use App\Form\PseudoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'accueil')]
class AccueilController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function indexAction(): Response
    {
        return $this->render("Accueil/accueil.html.twig");
    }

    #[Route('/score', name: '_score')]
    public function scoreAction(): Response
    {
        return $this->render("Accueil/score.html.twig");
    }

    #[Route('/choixPseudo', name: '_choixPseudo')]
    public function choixPseudoAction(Request $request, Session $session): Response
    {
        $form = $this->createForm(PseudoType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $session->set('joueur1', $form->getData()['pseudo1']);
            $session->set('joueur2', $form->getData()['pseudo2']);

            return $this->redirectToRoute('jeu_local_index');
        }

        $args = array(
            'Form' => $form->createView(),
        );

        return $this->render("Accueil/choixPseudo.html.twig", $args);
    }
}
