<?php

namespace App\Controller;

use App\Form\CaracteristiquePersoType;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaracteristiquePersoController extends AbstractController
{
    #[Route('/caracteristique/perso', name: 'app_caracteristique_perso')]
    public function index(): Response
    {
        return $this->render('caracteristique_perso/index.html.twig', [
            'controller_name' => 'CaracteristiquePersoController',
        ]);
    }
    #[Route('/caracteristique/perso', name: 'add_caracteristique_perso')] 
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {

        $entityManager = $doctrine->getManager();

        // Ajoutez une caractéristique au personnage
        $caracteristiquePersoForm = $this->createForm(CaracteristiquePersoType::class);
        $caracteristiquePersoForm->handleRequest($request);
        
        if ($caracteristiquePersoForm->isSubmitted() && $caracteristiquePersoForm->isValid()) {
            $caracPerso = $caracteristiquePersoForm->getData();
            $caracPerso->setPerso($perso);
        }
    }
}
