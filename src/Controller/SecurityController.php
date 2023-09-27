<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('/mesPerso');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/ban/user/{id}', name: 'ban_user')]
    public function banUser(ManagerRegistry $doctrine, User $user, Request $request): Response
    {
        // Si un utilisateur est connecter
        if($this->getUser()) {
            // et S'il est admin
            if($this->isGranted('ROLE_ADMIN')) {
                $entityManager = $doctrine->getManager();
                $roles = $user->getRoles();
                $roles[] = 'ROLE_BAN';
                $user->setRoles($roles);
                $entityManager->persist($user);
                $entityManager->flush();
            // Sinon
            } else {
                $session->getFlashBag()->add('error', "L'utilisateur connecter n'est pas un administrateur");
            }
        // Sinon
        } else {
            $session->getFlashBag()->add('error', "Veuillez vous connecter");
        }
        // Redirige vers la page actuelle (vide le cache du formulaire par la même occasion)
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }

    #[Route(path: '/unban/user/{id}', name: 'unban_user')]
    public function unBanUser(ManagerRegistry $doctrine, User $user, Request $request): Response
    {
        // Si un utilisateur est connecter
        if($this->getUser()) {
            // et S'il est admin
            if($this->isGranted('ROLE_ADMIN')) {
                $entityManager = $doctrine->getManager();
                $roles = $user->getRoles();
                $roles = array_diff($roles,array('ROLE_BAN'));
                $user->setRoles($roles);
                $entityManager->persist($user);
                $entityManager->flush();
            // Sinon
            } else {
                // On stock le message d'erreur suivant
                $session->getFlashBag()->add('error', "L'utilisateur connecter n'est pas un administrateur");
            }
        // Sinon
        } else {
            // On stock le message d'erreur suivant
            $session->getFlashBag()->add('error', "Veuillez vous connecter");
        }
        // Redirige vers la page actuelle (vide le cache du formulaire par la même occasion)
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
