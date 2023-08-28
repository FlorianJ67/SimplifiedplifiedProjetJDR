<?php

namespace App\Controller;

use DateTime;
use App\Entity\Objet;
use App\Entity\Perso;
use App\Form\ObjetType;
use App\Form\PersoType;
use App\Entity\Commentaire;
use App\Form\CompetenceType;
use App\Form\CommentaireType;
use App\Entity\CompetencePerso;
use App\Form\CaracteristiqueType;
use App\Form\CompetencePersoType;
use App\Entity\CaracteristiquePerso;
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

    #[Route('/perso/add/', name: 'add_perso')]
    #[Route('/perso/{id}/edit/', name: 'edit_perso')]
    public function add(ManagerRegistry $doctrine, Perso $perso = null, Request $request): Response
    {
        // Si il n'y pas d'utilisateur connecté 
        if(!$this->getUser()){
            // Redirige vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        // Si aucun personnage n'existe
        if (!$perso) {
            // Créer un moule
            $perso = new Perso();
        }
        // Créer/Modifier un personnnage     
        $persoForm = $this->createForm(PersoType::class, $perso);
        $persoForm->handleRequest($request);
        
        // Validation du formulaire:
        if ($persoForm->isSubmitted() && $persoForm->isValid()) {

            $perso = $persoForm->getData();
            // On créer un tableau pour vérifié les associations déjà résente
            $alreadyHave = [];
            // On prépare l'entity Manager
            $entityManager = $doctrine->getManager();
            // On assossie l'utilisateur au personnage
            $perso->setUser($this->getUser());
            // On met toutes les caractéristiques du personnage dans un tableau
            foreach($perso->getCaracteristiquePersos() as $persoCarac){ 
                array_push($alreadyHave, $persoCarac);
            }
            // On vérifie si le personnage à déjà une des Caractéristique qui a été enregistrer
            foreach($alreadyHave as $caracPersoHave ){
                foreach($alreadyHave as $caracPersoHaveCheck) {
                    // Si oui
                    if($caracPersoHave->getCaracteristique() == $caracPersoHaveCheck->getCaracteristique()){
                        // On remplace la valeur de la caractéristique déjà présente par la valeur de celle en doublon
                        $caracPersoHave->setValeur($caracPersoHaveCheck->getValeur());
                        // On supprime le doublon
                        $entityManager->remove($caracPersoHaveCheck);
                        $entityManager->persist($caracPersoHave);
                    // Si non 
                    } else {
                        // On lie le personnage a a nouvelle caractéristique
                        $caracPersoHaveCheck->setPerso($perso);
                        $entityManager->persist($caracPersoHaveCheck);
                    } 
                }
            }
            // On reset notre tableau
            $alreadyHave = [];
            // On met toutes les Compétences du personnage dans ce tableau
            foreach($perso->getCompetencePersos() as $persoComp){
                array_push($alreadyHave, $persoComp);
            }
            // On vérifie si le personnage à déjà une des compétence qui a été enregistrer
            foreach($alreadyHave as $compPersoHave ){
                foreach($alreadyHave as $compPersoHaveCheck) {
                    // Si oui
                    if($compPersoHave->getCompetence() == $compPersoHaveCheck->getCompetence()){
                        // On remplace la valeur de la compétence déjà présente par la valeur de celle en doublon
                        $compPersoHave->setValeur($compPersoHaveCheck->getValeur());
                        // On supprime le doublon
                        $entityManager->remove($compPersoHaveCheck);
                        $entityManager->persist($compPersoHave);
                    // Si non
                    } else {
                        // On lie le personnage a a nouvelle compétence
                        $compPersoHaveCheck->setPerso($perso);
                        $entityManager->persist($compPersoHaveCheck);
                    } 
                }
            }

            foreach($perso->getInventaires() as $objet) {
                $objet->setPerso($perso);
                $entityManager->persist($objet);
            }

            $entityManager->persist($perso);
            $entityManager->flush();
            // Redirection à la route Info Perso
            return $this->redirectToRoute('info_perso', ['id' => $perso->getId()]);
        }

        // Ajouté une Caractéristique
        $caracteristiqueForm = $this->createForm(CaracteristiqueType::class);
        $caracteristiqueForm->handleRequest($request);
        
        if ($caracteristiqueForm->isSubmitted() && $caracteristiqueForm->isValid()) {
            $carac = $caracteristiqueForm->getData();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($carac);
            $entityManager->flush();
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        // Ajouté une Compétence
        $competenceForm = $this->createForm(CompetenceType::class);
        $competenceForm->handleRequest($request);

        if ($competenceForm->isSubmitted() && $competenceForm->isValid()) {
            $comp = $competenceForm->getData();
            $entityManager = $doctrine->getManager();
            
            $entityManager->persist($comp);
            $entityManager->flush();
            
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        // Ajouté un Objet 
        $addObjetForm = $this->createForm(ObjetType::class);
        $addObjetForm->handleRequest($request);
        
        if ($addObjetForm->isSubmitted() && $addObjetForm->isValid()) {
            $objet = $addObjetForm->getData();
            $entityManager = $doctrine->getManager();

            // Si l'Objet existe déjà on le récupère
            if ($entityManager->getRepository(Objet::class)->findOneBy(['nom'=>$objet->getNom()]) && $entityManager->getRepository(Objet::class)->findOneBy(['valeur'=>$objet->getValeur()])){
                $objet = $entityManager->getRepository(Objet::class)->findOneBy(['nom'=>$objet->getNom()]);
            }

            $entityManager->persist($objet);            
            $entityManager->flush();
            
            return $this->redirectToRoute('edit_perso', ['id' => $perso->getId()]);
        }

        // Créer un Commentaire  
        $commentaireForm = $this->createForm(CommentaireType::class);
        $commentaireForm->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()) {

            $commentaire = $commentaireForm->getData();
            $commentaire->setPerso($perso);
            $commentaire->setUser($this->getUser());
            $commentaire->setCreatedAt(new DateTime());

            $entityManager->persist($commentaire);
            $entityManager->flush();
        }

        return $this->render('perso/add.html.twig', [
            'formAddPerso' => $persoForm->createView(),
            'formAddCaracteristique' => $caracteristiqueForm->createView(),
            'formAddCompetence' => $competenceForm->createView(),
            'formAddObjet' => $addObjetForm->createView(),
            'commentForm' => $commentaireForm,
            'perso' => $perso,
            'edit' => $perso->getId()
        ]);
    }

    #[Route('/perso/{id}/addToFav/', name: 'addToFav_perso')]
    public function addPersoToFav(ManagerRegistry $doctrine, Perso $perso): Response
    {     
        $entityManager = $doctrine->getManager();
        $perso->addUsersFav($this->getUser());
        $entityManager->flush();

        return $this->redirectToRoute('info_perso', ['id'=>$perso->getId()]);
    }

    #[Route('/perso/{id}/removeFav/', name: 'removeFav_perso')]
    public function removePersoToFav(ManagerRegistry $doctrine, Perso $perso): Response
    {     
        $entityManager = $doctrine->getManager();
        $this->getUser()->removePersoFav($perso);
        $entityManager->flush();

        return $this->redirectToRoute('info_perso', ['id'=>$perso->getId()]);
    }

    #[Route('/perso/{id}/', name: 'info_perso')]
    public function info(ManagerRegistry $doctrine, Perso $perso, Request $request): Response
    {    
        // Créer un commentaire  
        $commentaireForm = $this->createForm(CommentaireType::class);
        $commentaireForm->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()) {

            $commentaire = $commentaireForm->getData();
            $commentaire->setPerso($perso);
            $commentaire->setUser($this->getUser());
            $commentaire->setCreatedAt(new DateTime());

            $entityManager->persist($commentaire);
            $entityManager->flush();
        }

        return $this->render('perso/info.html.twig', [
            'perso' => $perso,
            'commentForm' => $commentaireForm
        ]);
    }
}
