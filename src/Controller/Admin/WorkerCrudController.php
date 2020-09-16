<?php

namespace App\Controller\Admin;

use App\Entity\Worker;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WorkerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Worker::class;
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
