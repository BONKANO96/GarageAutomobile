<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_index')]
    public function index(UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs de la base de données
        $users = $userRepository->findAll();

        // Passer les utilisateurs au template
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/create', name: 'user_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['is_new' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Initialiser les dates avant la sauvegarde
            $now = new \DateTimeImmutable();
            $user->setCreatedAt($now);
            $user->setUpdatedAt($now);
            $user->setPlainPassword($form->get('plainPassword')->getData());

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Utilisateur créé avec succès!');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}
