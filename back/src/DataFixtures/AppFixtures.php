<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        // Initialiser Faker
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        // Users
        $users = [];

        $admin = new User();
        $admin->setFullName('Bonkano Abdoul')
            ->setPseudo(null)
            ->setEmail('bonkano69@gmail.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPlainPassword('Mari1996&&')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        $users = [];

        $admin = new User();
        $admin->setFullName('Vincent Parrot')
            ->setPseudo(null)
            ->setEmail('vp@garage.tlse')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('adminpassword')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $users[] = $admin;
        $manager->persist($admin);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $users[] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
