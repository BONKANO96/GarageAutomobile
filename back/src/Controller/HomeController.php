<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Repository\OpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ServiceRepository $serviceRepository, OpeningHoursRepository $openingHoursRepository): Response
    {
        // Récupérer tous les services et les horaires d'ouverture depuis la base de données
        $services = $serviceRepository->findAll();
        $openingHours = $openingHoursRepository->findAll();

        // Passer les services et les horaires à la vue
        return $this->render('pages/home.html.twig', [
            'services' => $services,
            'opening_hours' => $openingHours,
            'controller_name' => 'HomeController',
        ]);
    }
}
