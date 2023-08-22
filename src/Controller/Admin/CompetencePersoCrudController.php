<?php

namespace App\Controller\Admin;

use App\Entity\CompetencePerso;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompetencePersoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CompetencePerso::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
