<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\DailyMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(
        DailyMenuRepository $dailyMenuRepository,
        CategoryRepository $categoryRepository
    ): Response
    {
        $today = new  \DateTime();
        $currentMenu = $dailyMenuRepository->createQueryBuilder('m')
            ->where(':today BETWEEN m.startDate AND m.endDate')
            ->setParameter('today', $today->format('Y-m-d'))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $this->render('main/index.html.twig', [
            'currentMenu' => $currentMenu,
            'categories' => $categoryRepository->findBy([], ['position' => 'ASC']),
        ]);
    }
}
