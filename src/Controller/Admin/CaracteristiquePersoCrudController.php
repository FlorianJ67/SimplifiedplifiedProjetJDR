<?php

namespace App\Controller\Admin;

use App\Entity\CaracteristiquePerso;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CaracteristiquePersoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CaracteristiquePerso::class;
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
