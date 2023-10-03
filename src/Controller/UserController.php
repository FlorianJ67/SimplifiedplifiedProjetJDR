<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // On prépare l'entity Manager
        $entityManager = $doctrine->getManager();
        // On récupère la liste des personnage de l'utilisateur
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/{id}/giveAdmin', name: 'give_role_user_admin')]
    public function giveAdmin(ManagerRegistry $doctrine, User $user = null, Request $request): Response
    {
        if($this->getUser()) {
            // Si l'utilisateur est un admin
            if($this->isGranted('ROLE_ADMIN')) {
                // On prépare l'entity Manager
                $entityManager = $doctrine->getManager();
                $role[] = "ROLE_ADMIN";
                $user->setRoles($role);
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }
        // On redirige sur la même page
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }

    #[Route('/user/{id}', name: 'info_user')]
    public function info(User $user = null): Response
    {
        if ($user) {

            return $this->render('user/info.html.twig', [
                'user' => $user,
                'perso' =>$user->getPersos(),
                'persoFav' =>$user->getPersoFav(),
            ]);
        } else {
            return $this->redirectToRoute('app_user');
        }
    }
}
