<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\CategoryRepository;
use App\Repository\DailyMenuRepository;
use App\Repository\DishRepository;
use App\Repository\GalleryRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(
        DailyMenuRepository $dailyMenuRepository,
        CategoryRepository $categoryRepository,
        ReviewRepository $reviewRepository,
        GalleryRepository $galleryRepository,
    ): Response
    {
        $today = new  \DateTime();

        // 1. Récupération du Polední menu (Daily Menu)
        $currentMenu = $dailyMenuRepository->createQueryBuilder('m')
            ->where('m.endDate >= :today')
            ->setParameter('today', $today)
            ->orderBy('m.startDate', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        // 2. Récupération des catégories et des plats (Stálá nabídka)
        $categories = $categoryRepository->createQueryBuilder('c')
            ->leftJoin('c.dishes', 'd')
            ->addSelect('d')
            ->where('d.isAvaible = :active') // On ne prend que les plats dispos
            ->setParameter('active', true)
            ->orderBy('c.position', 'ASC')
            //->addOrderBy('d.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        //recenze
        $reviews = $reviewRepository->findBy(['isAvaible' => true]);

        //Galerie
        $galeries = $galleryRepository->findBy([], ['priority' => 'DESC']);

        return $this->render('main/index.html.twig', [
            'currentMenu' => $currentMenu,
            'categories' => $categories,
            'reviews' => $reviews,
            'galleries' => $galeries
        ]);
    }

}
