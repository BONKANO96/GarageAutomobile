<?php

namespace App\Controller;

use App\Repository\CarRepository;  // Ajouter ce repository pour les voitures
use App\Repository\ServiceRepository;
use App\Repository\OpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        ServiceRepository $serviceRepository, 
        OpeningHoursRepository $openingHoursRepository, 
        CarRepository $carRepository // Ajouter le repository des voitures
    ): Response {
        // Récupérer tous les services et les horaires d'ouverture depuis la base de données
        $services = $serviceRepository->findAll();
        $openingHours = $openingHoursRepository->findAll();

        // Récupérer les trois voitures d'occasion les plus récentes
        $cars = $carRepository->findBy([], ['year' => 'DESC'], 3);

        // Passer les services, les horaires et les voitures à la vue
        return $this->render('pages/home.html.twig', [
            'services' => $services,
            'opening_hours' => $openingHours,
            'cars' => $cars,  // Envoyer les voitures à la vue
            'controller_name' => 'HomeController',
        ]);
    }
}
