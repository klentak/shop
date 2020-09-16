<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Day;
use App\Entity\Worker;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     * 
     * @return Response
     */
    public function index(): Response
    {
        // $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        // return $this->redirect($routeBuilder->setController(LocationCrudController::class)->generateUrl());
        return parent::index();
    }

    public function configureMenuItems(): iterable
    {
        return[
            MenuItem::linkToCrud('Locations', 'fa fa-home', Location::class),
            MenuItem::linkToCrud('Days', 'fa fa-calendar', Day::class),
            MenuItem::section('Użytkownicy'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Worker', 'fa fa-user', Worker::class),
        ];
    }
}
