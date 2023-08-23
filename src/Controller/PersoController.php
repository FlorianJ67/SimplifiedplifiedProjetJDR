<?php

namespace App\Controller;

use App\Entity\Perso;
use App\Form\ObjetType;
use App\Form\PersoType;
use App\Form\CompetenceType;
use App\Form\CaracteristiqueType;
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
        // Si aucune personnage n'existe: créer un moule
        if (!$perso) {
            $perso = new Perso();
        }
        // Créer/Modifier un personnnage     
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

        // Ajoutez une caractéristique au personnage
        $caracteristiquePersoForm = $this->createForm(CaracteristiquePersoType::class);
        $caracteristiquePersoForm->handleRequest($request);
        
        if ($caracteristiquePersoForm->isSubmitted() && $caracteristiquePersoForm->isValid()) {
            $caracPerso = $caracteristiquePersoForm->getData();
            $entityManager = $doctrine->getManager();
            $caracPerso->setPerso($perso);

            foreach ($perso->getCaracteristiquePersos() as $CaracteristiquePersos ) {
                if ($CaracteristiquePersos->getCaracteristique() == $caracPerso->getCaracteristique()) {
                    $CaracteristiquePersos->setValeur($caracPerso->getValeur());
                    $editMode = true;
                }
            }
            if (!$editMode) {
                $entityManager->persist($caracPerso);
            }
            $entityManager->flush();
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        // Ajoutez une caractéristique
        $caracteristiqueForm = $this->createForm(CaracteristiqueType::class);
        $caracteristiqueForm->handleRequest($request);
        
        if ($caracteristiqueForm->isSubmitted() && $caracteristiqueForm->isValid()) {
            $carac = $caracteristiqueForm->getData();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($carac);
            $entityManager->flush();
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        // Ajoutez une competence au personnage
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

        // Ajoutez une competence
        $competenceForm = $this->createForm(CompetenceType::class);
        $competenceForm->handleRequest($request);

        if ($competenceForm->isSubmitted() && $competenceForm->isValid()) {
            $comp = $competenceForm->getData();
            $entityManager = $doctrine->getManager();
            
            $entityManager->persist($comp);
            $entityManager->flush();
            
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        // Ajoutez un ibjet au personnage
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
            'formAddCaracteristique' => $caracteristiqueForm->createView(),
            'formAddCompetence' => $competenceForm->createView(),
            'formAddObjet' => $objetForm->createView(),
            'perso' => $perso,
            'edit' => $perso->getId()
        ]);
    }

    #[Route('/perso/{id}/addToFav', name: 'addToFav_perso')]

    public function addPersoToFav(ManagerRegistry $doctrine, Perso $perso): Response
    {     
        $entityManager = $doctrine->getManager();
        $perso->addUsersFav($this->getUser());
        $entityManager->flush();

        return $this->render('perso/info.html.twig', [
            'perso' => $perso
        ]);
    }

    #[Route('/perso/{id}/removeFav', name: 'removeFav_perso')]

    public function removePersoToFav(ManagerRegistry $doctrine, Perso $perso): Response
    {     
        $entityManager = $doctrine->getManager();
        $this->getUser()->removePersoFav($perso);
        $entityManager->flush();

        return $this->render('perso/info.html.twig', [
            'perso' => $perso
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
