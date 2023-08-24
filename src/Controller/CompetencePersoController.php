<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetencePersoController extends AbstractController
{
    #[Route('/competence/perso', name: 'app_competence_perso')]
    public function index(): Response
    {
        return $this->render('competence_perso/index.html.twig', [
            'controller_name' => 'CompetencePersoController',
        ]);
    }
}
