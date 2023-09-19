<?php

namespace App\Controller\Admin;

use App\Entity\Objet;
use App\Entity\Perso;
use App\Entity\Competence;
use App\Entity\Caracteristique;
use App\Entity\CompetenceInflueCarac;
use App\Controller\Admin\PersoCrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $admin=false;
        // On vérifie que l'utilisateur est un administrator
        if ($this->getUser()) {
            // On parcours les roles pour voir si ROLE_ADMIN en fait parti
            foreach ($this->getUser()->getRoles() as $role) {
                if ($role == 'ROLE_ADMIN') {
                    $admin = true;
                }
            }
            // Si oui on redirige vers le dashboard
            if ($admin) {
                $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
                return $this->redirect($adminUrlGenerator->setController(PersoCrudController::class)->generateUrl());
            }
        }
        // Si non on redirgie vers l'acceuil du site
        return $this->redirectToRoute('app_home');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SimplifiedplifiedProjetJDR');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Perso', 'fas fa-list', Perso::class);
        yield MenuItem::linkToCrud('Competence', 'fas fa-list', Competence::class);
        yield MenuItem::linkToCrud('Caracteristique', 'fas fa-list', Caracteristique::class);
        yield MenuItem::linkToCrud('CompetenceInflueCarac', 'fas fa-list', CompetenceInflueCarac::class);
        yield MenuItem::linkToCrud('Objet', 'fas fa-list', Objet::class);
    }
}
