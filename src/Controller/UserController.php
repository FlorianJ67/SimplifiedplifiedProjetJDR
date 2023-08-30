<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/{id}', name: 'info_user')]
    public function info(User $user): Response
    {
        return $this->render('user/info.html.twig', [
            'user' => $user,
            'perso' =>$user->getPersos(),
            'persoFav' =>$user->getPersoFav(),
        ]);
    }
}
