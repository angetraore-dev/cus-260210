<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Configuration;
use App\Entity\DailyMenu;
use App\Entity\Dish;
use App\Entity\OpeningHour;
use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // 1. On récupère le générateur d'URL d'EasyAdmin
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // 2. On redirige vers le CRUD des Réservations
        return $this->redirect(
            $adminUrlGenerator->setController(ReservationCrudController::class)->generateUrl());

        //return parent::index();



        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cus 260210');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Restaurant Menu');

        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class)
            ->setController(CategoryCrudController::class);

        yield MenuItem::linkToCrud('Dishes', 'fa fa-utensils', Dish::class)
            ->setController(DishCrudController::class);

        // (Polední menu)
        yield MenuItem::section('Daily Operations');
        yield MenuItem::linkToCrud('Daily Menu', 'fa fa-calendar-day', DailyMenu::class);


        //Management: Reservation and Opening Hours and configuration_user
        yield MenuItem::section('Management');

        yield MenuItem::linkToCrud('Reservations', 'fa fa-calendar-check', Reservation::class)
            ->setController(ReservationCrudController::class)
            ->setBadge(5, 'danger')
        ;
        yield MenuItem::linkToCrud('Opening Hours', 'fa fa-clock', OpeningHour::class)
            ->setController(OpeningHourCrudController::class);

        yield MenuItem::section('Settings');
        yield MenuItem::linkToCrud('Global Config', 'fa fa-cog', Configuration::class)
            ->setController(ConfigurationCrudController::class);

    }
}
