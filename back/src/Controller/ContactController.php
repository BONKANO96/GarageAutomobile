<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setNom($form->get('nom')->getData())
                    ->setPrenom($form->get('prenom')->getData())
                    ->setEmail($form->get('email')->getData())
                    ->setTelephone($form->get('telephone')->getData())
                    ->setSujet($form->get('sujet')->getData())
                    ->setMessage($form->get('message')->getData());

            // Sauvegarde du message dans la base de données
            $entityManager->persist($contact);
            $entityManager->flush();

            // Message de confirmation
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Rediriger ou afficher un message de confirmation
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
