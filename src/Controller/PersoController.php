<?php

namespace App\Controller;

use App\Entity\Perso;
use App\Form\ObjetType;
use App\Form\PersoType;
use App\Form\CompetencePersoType;
use App\Form\CaracteristiquePersoType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersoController extends AbstractController
{
    #[Route('/perso', name: 'app_perso')]
    public function index(): Response
    {
        return $this->render('perso/index.html.twig', [
            'controller_name' => 'PersoController',
        ]);
    }

    #[Route('/perso/add', name: 'add_perso')]
    #[Route('/perso/{id}/edit/', name: 'edit_perso')]
    public function add(ManagerRegistry $doctrine, Perso $perso = null, Request $request): Response
    {
        if (!$perso) {
            $perso = new Perso();
        }     
        $persoForm = $this->createForm(PersoType::class, $perso);
        $persoForm->handleRequest($request);
        
        if ($persoForm->isSubmitted() && $persoForm->isValid()) {
            $perso = $persoForm->getData();
            $entityManager = $doctrine->getManager();
            
            $perso->setUser($this->getUser());
            $entityManager->persist($perso);
            $entityManager->flush();
            
            return $this->redirectToRoute('info_perso', ['id' => $perso->getId()]);
        }

        $caracteristiquePersoForm = $this->createForm(CaracteristiquePersoType::class);
        $caracteristiquePersoForm->handleRequest($request);
        
        if ($caracteristiquePersoForm->isSubmitted() && $caracteristiquePersoForm->isValid()) {
            $caracPerso = $caracteristiquePersoForm->getData();
            $entityManager = $doctrine->getManager();
            $caracPerso->setPerso($perso);

            $entityManager->persist($caracPerso);
            $entityManager->flush();
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        $competencePersoForm = $this->createForm(CompetencePersoType::class);
        $competencePersoForm->handleRequest($request);
        
        if ($competencePersoForm->isSubmitted() && $competencePersoForm->isValid()) {
            $compPerso = $competencePersoForm->getData();
            $entityManager = $doctrine->getManager();
            
            $compPerso->setPerso($perso);
            $entityManager->persist($compPerso);
            $entityManager->flush();
            
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        $objetForm = $this->createForm(ObjetType::class);
        $objetForm->handleRequest($request);
        
        if ($objetForm->isSubmitted() && $objetForm->isValid()) {
            $objet = $objetForm->getData();
            $entityManager = $doctrine->getManager();
            
            $objet->setPerso($perso);
            $entityManager->persist($objet);
            $entityManager->flush();
            
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        return $this->render('perso/add.html.twig', [
            'formAddPerso' => $persoForm->createView(),
            'formAddCaracteristiquePerso' => $caracteristiquePersoForm->createView(),
            'formAddCompetencePerso' => $competencePersoForm->createView(),
            'formAddObjet' => $objetForm->createView(),
            'perso' => $perso,
            'edit' => $perso->getId()
        ]);
    }

    #[Route('/perso/{id}/', name: 'info_perso')]

    public function info(ManagerRegistry $doctrine, Perso $perso): Response
    {     
        return $this->render('perso/info.html.twig', [
            'perso' => $perso
        ]);
    }
}
