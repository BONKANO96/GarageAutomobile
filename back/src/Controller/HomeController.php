<?php

// src/Controller/HomeController.php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        // Récupérer tous les services depuis la base de données
        $services = $serviceRepository->findAll();

        // Passer les services à la vue
        return $this->render('pages/home.html.twig', [
            'services' => $services,
            'controller_name' => 'HomeController',
        ]);
    }
}