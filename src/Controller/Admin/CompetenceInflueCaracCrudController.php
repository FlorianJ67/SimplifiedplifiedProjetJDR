<?php

namespace App\Controller\Admin;

use App\Entity\CompetenceInflueCarac;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompetenceInflueCaracCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CompetenceInflueCarac::class;
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
