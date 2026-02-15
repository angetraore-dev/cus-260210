<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Configuration;
use App\Entity\DailyMenu;
use App\Entity\Dish;
use App\Entity\Gallery;
use App\Entity\OpeningHour;
use App\Entity\Reservation;
use App\Entity\Review;
use App\Enum\ReservationStatus;
use App\Repository\ConfigurationRepository;
use App\Repository\ReservationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
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
    private ReservationRepository $reservationRepository;
    private ConfigurationRepository $configurationRepository;
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        ReservationRepository $reservationRepository,
        ConfigurationRepository $configurationRepository
    ) {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->configurationRepository = $configurationRepository;
        $this->reservationRepository = $reservationRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Redirection par défaut vers les réservations
        return $this->redirect(
            $this->adminUrlGenerator->setController(ReservationCrudController::class)->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AUREA');
    }

    public function configureMenuItems(): iterable
    {
        // 1. Gestion des badges pour les réservations en attente
        $pendingReservation = $this->reservationRepository->count([
            'status' => ReservationStatus::PENDING
        ]);

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // --- SECTION MENU ---
        yield MenuItem::section('Restaurant Menu');
        yield MenuItem::linkToCrud('Kategorie', 'fa fa-tags', Category::class);
        yield MenuItem::linkToCrud('Jídelní lístek', 'fa fa-utensils', Dish::class);

        // --- SECTION OPERATIONS ---
        yield MenuItem::section('Daily Operations');
        yield MenuItem::linkToCrud('Daily Menu', 'fa fa-calendar-day', DailyMenu::class);

        // --- SECTION MANAGEMENT ---
        yield MenuItem::section('Management');

        $resItem = MenuItem::linkToCrud('Rezervace', 'fa fa-calendar-check', Reservation::class);
        if ($pendingReservation > 0) {
            $resItem->setBadge($pendingReservation, 'danger');
        }
        yield $resItem;

        yield MenuItem::linkToCrud('Otevírací doba', 'fa fa-clock', OpeningHour::class);
        yield MenuItem::linkToCrud('Recenze', 'fa fa-star', Review::class);

        // --- SECTION SETTINGS ---
        yield MenuItem::section('Settings');
        yield MenuItem::linkToCrud('Galerie', 'fas fa-images', Gallery::class);

        // --- LOGIQUE CONFIGURATION UNIQUE ---
        $config = $this->configurationRepository->findOneBy([]);

        if (!$config) {
            // Si aucune config n'existe, on pointe vers l'index (ou le bouton "New" s'affichera normalement)
            yield MenuItem::linkToCrud('Nastavení webu', 'fas fa-cog', Configuration::class);
        } else {
            // Si elle existe, on génère une URL d'édition précise pour éviter les erreurs de droits au rendu
            $url = $this->adminUrlGenerator
                ->setController(ConfigurationCrudController::class)
                ->setAction(Action::EDIT)
                ->setEntityId($config->getId())
                ->generateUrl();

            yield MenuItem::linkToUrl('Nastavení webu', 'fas fa-cog', $url);
        }
    }
}


//
//
//namespace App\Controller\Admin;
//
//use App\Entity\Category;
//use App\Entity\Configuration;
//use App\Entity\DailyMenu;
//use App\Entity\Dish;
//use App\Entity\Gallery;
//use App\Entity\OpeningHour;
//use App\Entity\Reservation;
//use App\Entity\Review;
//use App\Enum\ReservationStatus;
//use App\Repository\ConfigurationRepository;
//use App\Repository\ReservationRepository;
//use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
//use Symfony\Component\Routing\Attribute\Route;
//use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
//use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
//use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
//use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
//use Symfony\Component\HttpFoundation\Response;
//
//#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
//class DashboardController extends AbstractDashboardController
//{
//    private ReservationRepository $reservationRepository;
//    private ConfigurationRepository $configurationRepository;
//    private $adminUrlGenerator;
//
//    public function __construct(AdminUrlGenerator $adminUrlGenerator, ReservationRepository $reservationRepository, ConfigurationRepository $configurationRepository)
//    {
//        $this->adminUrlGenerator = $adminUrlGenerator;
//        $this->configurationRepository = $configurationRepository;
//        $this->reservationRepository = $reservationRepository;
//
//    }
//    #[Route('/admin', name: 'admin')]
//    public function index(): Response
//    {
//        // 1. On récupère le générateur d'URL d'EasyAdmin
//        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
//
//        // 2. On redirige vers le CRUD des Réservations
//        return $this->redirect(
//            $adminUrlGenerator->setController(ReservationCrudController::class)->generateUrl());
//
//        //return parent::index();
//
//
//
//        // Option 1. You can make your dashboard redirect to some common page of your backend
//        //
//        // 1.1) If you have enabled the "pretty URLs" feature:
//        // return $this->redirectToRoute('admin_user_index');
//        //
//        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
//        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
//        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());
//
//        // Option 2. You can make your dashboard redirect to different pages depending on the user
//        //
//        // if ('jane' === $this->getUser()->getUsername()) {
//        //     return $this->redirectToRoute('...');
//        // }
//
//        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
//        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
//        //
//        // return $this->render('some/path/my-dashboard.html.twig');
//    }
//
//    public function configureDashboard(): Dashboard
//    {
//        return Dashboard::new()
//            ->setTitle('AUREA');
//    }
//
//    public function configureMenuItems(): iterable
//    {
//        $pendindReservation = $this->reservationRepository->count([
//            'status' => ReservationStatus::PENDING
//        ]);
//
//
//        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
//
//
//        // On compte le nombre d'entités existantes
//        //$configCount = $this->container->get(ConfigurationRepository::class)->count([])
//        $configCount = $this->configurationRepository->count([]);
//
//        yield MenuItem::section('Restaurant Menu');
//
//        // Menu pour les catégories (Předkrmy, Hlavní chody...)
//        yield MenuItem::linkToCrud('Kategorie', 'fa fa-tags', Category::class)
//            ->setController(CategoryCrudController::class);
//
//        yield MenuItem::linkToCrud('Jídelní lístek', 'fa fa-utensils', Dish::class)
//            ->setController(DishCrudController::class);
//
//        // (Polední menu)
//        yield MenuItem::section('Daily Operations');
//        yield MenuItem::linkToCrud('Daily Menu', 'fa fa-calendar-day', DailyMenu::class);
//
//
//        //Management: Reservation and Opening Hours and configuration_user
//        yield MenuItem::section('Management');
//
//        $menuItem =  MenuItem::linkToCrud('Rezervace', 'fa fa-calendar-check', Reservation::class)
//            ->setController(ReservationCrudController::class);
//        if ($pendindReservation > 0){
//            $menuItem->setBadge($pendindReservation, 'danger');
//        }
//        yield $menuItem;
//
//       // yield MenuItem::linkToCrud('Otevírací doba', 'fas fa-clock', OpeningHour::class);
//        yield MenuItem::linkToCrud('Otevírací doba', 'fa fa-clock', OpeningHour::class)
//            ->setController(OpeningHourCrudController::class)
//        ;
//
//        //recenze
//        yield MenuItem::linkToCrud('Recenze', 'fa fa-star', Review::class)
//            ->setController(ReviewCrudController::class)
//        ;
//
//        //Settings
//        yield MenuItem::section('Settings');
//        yield MenuItem::linkToCrud('Galerie', 'fas fa-images', Gallery::class);
//
//        if ($configCount === 0) {
//            // Si aucune config, on permet d'en créer une
//            yield MenuItem::linkToCrud('Nastavení webu', 'fas fa-cog', Configuration::class)
//                ->setAction('new');
//        } else {
//            // Si elle existe, on pointe directement vers l'édition de la ligne ID 1
//            $config = $this->configurationRepository->findOneBy([]);
//            yield MenuItem::linkToCrud('Nastavení webu', 'fas fa-cog', Configuration::class)
//                ->setAction('edit')
//                ->setEntityId($config->getId());
//        }
//
//        //yield MenuItem::linkToCrud('Global Config', 'fa fa-cog', Configuration::class)
//        //            ->setController(ConfigurationCrudController::class)
//        //        ;
//
//
//    }
//}
