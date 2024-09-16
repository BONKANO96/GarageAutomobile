<?php

namespace App\Controller;

use App\Entity\OpeningHours;
use App\Form\OpeningHoursType;
use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpeningHoursController extends AbstractController
{
    #[Route('/opening-hours', name: 'app_opening_hours')]
    public function index(OpeningHoursRepository $openingHoursRepository): Response
    {
        // Récupérer tous les horaires d'ouverture depuis la base de données
        $openingHours = $openingHoursRepository->findAll();

        return $this->render('opening_hours/index.html.twig', [
            'opening_hours' => $openingHours,
        ]);
    }

    #[Route('/opening-hours/new', name: 'app_opening_hours_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $openingHours = new OpeningHours();
        $form = $this->createForm(OpeningHoursType::class, $openingHours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les nouveaux horaires
            $entityManager->persist($openingHours);
            $entityManager->flush();

            return $this->redirectToRoute('app_opening_hours');
        }

        return $this->render('opening_hours/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/opening-hours/edit/{id}', name: 'app_opening_hours_edit')]
    public function edit(Request $request, OpeningHours $openingHours, EntityManagerInterface $entityManager): Response
    {
        // Créer un formulaire pour éditer les horaires d'ouverture
        $form = $this->createForm(OpeningHoursType::class, $openingHours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les changements
            $entityManager->flush();

            // Rediriger vers la page d'affichage des horaires
            return $this->redirectToRoute('app_opening_hours');
        }

        // Afficher le formulaire dans la vue
        return $this->render('opening_hours/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/opening-hours/delete/{id}', name: 'app_opening_hours_delete', methods: ['POST'])]
    public function delete(Request $request, OpeningHours $openingHours, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $openingHours->getId(), $request->request->get('_token'))) {
            // Supprimer les horaires d'ouverture
            $entityManager->remove($openingHours);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_opening_hours');
    }
}
