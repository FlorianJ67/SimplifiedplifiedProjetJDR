<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    #[Route(path: '/modify/user/{id}/pseudo', name: 'modifiy_user_pseudo')]
    public function modifyPseudoUser(ManagerRegistry $doctrine, User $user, Request $request): Response
    {
        // Si un utilisateur est connecter
        if($this->getUser()) {
            // et S'il est l'utilisateur concerné ou un admin
            if($this->getUser() == $user || $this->isGranted('ROLE_ADMIN')) {
                $entityManager = $doctrine->getManager();
                $modifyUser = ['message' => 'Type your message here'];
                $modifyUserForm = $this->createFormBuilder($modifyUser)
                    ->add('pseudo',TextType::class)
                    ->add('submit', SubmitType::class)
                    ->getForm();
                $modifyUserForm->handleRequest($request);
                if($modifyUserForm->isSubmitted() && $modifyUserForm->isValid()) {
                    $user->setPseudo($modifyUserForm->getData()['pseudo']);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->render('user/info.html.twig', [
                        'user' => $user,
                        'perso' =>$user->getPersos(),
                        'persoFav' =>$user->getPersoFav()
                    ]);
                }
                return $this->render('user/modify.html.twig', [
                    'modifyPseudoUserForm' => $modifyUserForm,
                    'modifyPasswordUserForm' => null,
                    'user' => $user
                ]);
            // Sinon
            } else {
                if (!$this->isGranted('ROLE_ADMIN')) {
                    $this->addFlash('error', "L'utilisateur connecter n'est pas un administrateur");
                } else {
                    $this->addFlash('error', "Vous n'avez pas l'autorisation de faire ça");
                }
            }
        // Sinon
        } else {
            $this->addFlash('error', "Veuillez vous connecter");
        }
        // Redirige vers la page actuelle (vide le cache du formulaire par la même occasion)
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }

    #[Route(path: '/modify/user/{id}/password', name: 'modify_user_password')]
    public function modifyPasswordUser(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher, User $user, Request $request): Response
    {
        // Si un utilisateur est connecter
        if($this->getUser()) {
            // et S'il est l'utilisateur concerné ou un admin
            if($this->getUser() == $user || $this->isGranted('ROLE_ADMIN')) {
                $entityManager = $doctrine->getManager();
                $modifyUser = ['message' => 'Type your message here'];
                // On génère le formulaire de modification
                $modifyUserForm = $this->createFormBuilder($modifyUser)
                    ->add('currentPassword', PasswordType::class)
                    ->add('password',RepeatedType::class, [
                        'type' => PasswordType::class,
                        'invalid_message' => 'The password fields must match.',
                        'options' => ['attr' => ['class' => 'password-field']],
                        'required' => true,
                        'first_options'  => ['label' => 'Password'],
                        'second_options' => ['label' => 'Repeat Password'],
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Please enter a password',
                            ]),
                            new Length([
                                'min' => 6,
                                'minMessage' => 'Your password should be at least {{ limit }} characters',
                                // max length allowed by Symfony for security reasons
                                'max' => 4096,
                            ]),
                        ],
                    ])
                    ->add('submit', SubmitType::class)
                    ->getForm();
                $modifyUserForm->handleRequest($request);
                // Si le formulaire est envoyer et valide
                if($modifyUserForm->isSubmitted() && $modifyUserForm->isValid()) {
                    // On récupère l'input du 'currentPassword' (mot de passe actuel)
                    $oldPassword = $modifyUserForm->getData()['currentPassword'];
                    // On le compare avec le mot de passe actuel de l'utilisateur
                    if($passwordHasher->isPasswordValid($user, $oldPassword)) {
                        // On hash l'input du nouveau mot de passe
                        $hashedPassword = $passwordHasher->hashPassword(
                            $user,
                            $modifyUserForm->getData()['password']
                        );
                        // On définie le nouveau mot de passe hasher dans la base de donnée
                        $user->setPassword($hashedPassword);
                        // On prépare les modifications
                        $entityManager->persist($user);
                        // On applique les modifications à la base de données
                        $entityManager->flush();
                        // On redirige vers la page de l'utilisateur
                        return $this->render('user/info.html.twig', [
                            'user' => $user,
                            'perso' =>$user->getPersos(),
                            'persoFav' =>$user->getPersoFav()
                        ]);
                    } else {
                        $this->addFlash('error', "Le mot de passe actuel ne correspond pas");
                    }
                }
                return $this->render('user/modify.html.twig', [
                    'modifyPasswordUserForm' => $modifyUserForm,
                    'modifyPseudoUserForm' => null,
                    'user' => $user
                ]);
            // Sinon
            } else {
                if (!$this->isGranted('ROLE_ADMIN')) {
                    $this->addFlash('error', "L'utilisateur connecter n'est pas un administrateur");
                } else {
                    $this->addFlash('error', "Vous n'avez pas l'autorisation de faire ça");
                }
            }
        // Sinon
        } else {
            $this->addFlash('error', "Veuillez vous connecter");
        }
        // Redirige vers la page actuelle (vide le cache du formulaire par la même occasion)
        $route = $request->headers->get('referer');
        return $this->redirect($route);
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
                $this->addFlash('error', "L'utilisateur connecter n'est pas un administrateur");
            }
        // Sinon
        } else {
            $this->addFlash('error', "Veuillez vous connecter");
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
                $this->addFlash('error', "L'utilisateur connecter n'est pas un administrateur");
            }
        // Sinon
        } else {
            // On stock le message d'erreur suivant
            $this->addFlash('error', "Veuillez vous connecter");
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
