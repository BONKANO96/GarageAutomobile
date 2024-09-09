<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        // Initialiser Faker et l'encodeur de mot de passe
        $this->faker = Factory::create();
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Liste des utilisateurs
        $users = [];

        // Création d'un administrateur
        $admin = new User();
        $admin->setFirstName('Vincent')
            ->setLastName('Parrot')
            ->setEmail('vp@garage.tlse')
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        // Encodage du mot de passe de l'admin
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'adminpassword');
        $admin->setPassword($hashedPassword);

        // Enregistrement de l'admin
        $users[] = $admin;
        $manager->persist($admin);

        // Création de 10 utilisateurs avec Faker
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            // Encodage du mot de passe pour chaque utilisateur
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);

            $users[] = $user;
            $manager->persist($user);
        }

        // Flush pour sauvegarder les utilisateurs en base
        $manager->flush();
    }
}
