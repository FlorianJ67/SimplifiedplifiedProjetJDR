<?php

namespace App\Controller;

use App\Entity\Action;
use App\Form\ActionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActionController extends AbstractController
{
    #[Route('/action', name: 'app_action')]
    public function index(): Response
    {
        return $this->render('action/index.html.twig', [
            'controller_name' => 'ActionController',
        ]);
    }

    #[Route('/action/add/', name: 'add_action')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        // Créer une action     
        $actionForm = $this->createForm(ActionType::class);
        $actionForm->handleRequest($request);
        
        // Validation du formulaire:
        if ($actionForm->isSubmitted() && $actionForm->isValid()) {
            // On récupère les donnees du formulaire
            $action = $actionForm->getData();
            // On prépare l'entity Manager
            $entityManager = $doctrine->getManager();

            $diceScore = rand(1, $action->getDice());

            $action->setDiceScore($diceScore);

            $entityManager->persist($action);
            $entityManager->flush();

            return $this->redirectToRoute('info_action', ['id' => $action->getId()]);
        }

            
        return $this->render('action/add.html.twig', [
            'formAction' => $actionForm->createView(),
        ]);
    }

    #[Route('/action/{id}/', name: 'info_action')]
    public function info(ManagerRegistry $doctrine, Action $action = null, Request $request): Response
    {    
        return $this->render('action/info.html.twig', [
            'action' => $action
        ]);

    }

}
