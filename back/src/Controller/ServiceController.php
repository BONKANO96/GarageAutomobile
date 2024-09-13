<?php
namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ServiceRepository $serviceRepository;

    public function __construct(EntityManagerInterface $entityManager, ServiceRepository $serviceRepository)
    {
        $this->entityManager = $entityManager;
        $this->serviceRepository = $serviceRepository;
    }

    #[Route('/services', name: 'app_service')]
    public function index(): Response
    {
        $services = $this->serviceRepository->findAll();
        return $this->render('service/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/services/create', name: 'app_service_create')]
    public function create(Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($service);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_service');
        }

        return $this->render('service/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/services/{id}/edit', name: 'app_service_edit')]
    public function edit(Service $service, Request $request): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_service');
        }

        return $this->render('service/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/services/{id}/delete', name: 'app_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($service);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_service');
    }
}
