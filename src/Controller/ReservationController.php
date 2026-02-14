<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservationController extends AbstractController
{
    #[Route('/reservation/ajax-form', name: 'app_reservation_form_ajax')]
    public function getForm(): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        return $this->render('reservation/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation/submit', name: 'app_reservation_submit', methods: ['POST'])]
    public function submit(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Vaše rezervace byla úspěšně přijata. Těšíme se na Vás v Aurea!'
            ]);
        }

        // SI ERREUR : On récupère les erreurs du formulaire
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return new JsonResponse([
            'success' => false,
            'message' => 'Opravte prosím chyby v formuláři.',
            'errors' => $errors // On envoie la liste des messages tchèques
        ], 400);

    }
}
