<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/cars', name: 'app_car_index')]
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findAllCars();

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/car/new', name: 'app_car_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $mainImageFile */
            $mainImageFile = $form->get('mainImage')->getData();

            if ($mainImageFile) {
                $newFilename = uniqid().'.'.$mainImageFile->guessExtension();

                try {
                    $mainImageFile->move(
                        $this->getParameter('cars_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image principale.');
                }

                $car->setMainImageFilename($newFilename);
            }

            /** @var UploadedFile[] $galleryFiles */
            $galleryFiles = $form->get('gallery')->getData();

            if ($galleryFiles) {
                $gallery = [];
                foreach ($galleryFiles as $galleryFile) {
                    $galleryFilename = uniqid().'.'.$galleryFile->guessExtension();

                    try {
                        $galleryFile->move(
                            $this->getParameter('cars_images_directory'),
                            $galleryFilename
                        );
                        $gallery[] = $galleryFilename;
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Erreur lors du téléchargement des images de la galerie.');
                    }
                }
                $car->setGallery($gallery);
            }

            $features = $form->get('features')->getData();
            if ($features) {
                $car->setFeatures($features);
            }

            $options = $form->get('options')->getData();
            if ($options) {
                $car->setOptions($options);
            }

            $entityManager->persist($car);
            $entityManager->flush();

            $this->addFlash('success', 'La voiture a été ajoutée avec succès.');

            return $this->redirectToRoute('app_car_index');
        }

        return $this->render('car/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/car/{id}/edit', name: 'app_car_edit')]
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gallery = $form->get('gallery')->getData();
            if ($gallery) {
                $car->setGallery($gallery);
            }

            $options = $form->get('options')->getData();
            if ($options) {
                $car->setOptions($options);
            }

            $features = $form->get('features')->getData();
            if ($features) {
                $car->setFeatures($features);
            }

            $entityManager->flush();

            $this->addFlash('success', 'La voiture a été modifiée avec succès.');

            return $this->redirectToRoute('app_car_index');
        }

        return $this->render('car/edit.html.twig', [
            'form' => $form->createView(),
            'car' => $car,
        ]);
    }

    #[Route('/car/{id}/delete', name: 'app_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();

            $this->addFlash('success', 'La voiture a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_car_index');
    }

    #[Route('/car_list', name: 'car_list')]
    public function list(CarRepository $carRepository, Request $request)
    {
        // Récupérer les filtres du formulaire
        $minPrice = $request->query->get('min_price');
        $maxPrice = $request->query->get('max_price');
        $minYear = $request->query->get('min_year');
        $maxYear = $request->query->get('max_year');
        $minMileage = $request->query->get('min_mileage');
        $maxMileage = $request->query->get('max_mileage');

        // Appliquer les filtres dans le repository
        $cars = $carRepository->findFilteredCars($minPrice, $maxPrice, $minYear, $maxYear, $minMileage, $maxMileage);

        return $this->render('car/list.html.twig', [
            'cars' => $cars,
        ]);
    }



}
