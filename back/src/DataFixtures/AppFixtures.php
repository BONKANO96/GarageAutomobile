<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\Car;
use App\Entity\User;
use App\Entity\Service;
use App\Entity\OpeningHours; // Import de l'entité OpeningHours
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

        // Création des services proposés par le garage
        $services = [
            ['Réparations mécaniques', 'Réparation de tout type de pannes mécaniques pour tous types de véhicules.'],
            ['Entretien de véhicules', 'Services d’entretien régulier incluant les vidanges, les contrôles des freins, et les révisions.'],
            ['Vente de véhicules d\'occasion', 'Large gamme de véhicules d’occasion en vente avec contrôle technique assuré.'],
            ['Prise en charge spéciale', 'Service de prise en charge sur mesure pour répondre aux besoins spécifiques des clients.']
        ];

        foreach ($services as $serviceData) {
            $service = new Service();
            $service->setNom($serviceData[0])
                    ->setDescription($serviceData[1]);

            $manager->persist($service);
        }

        // Création des horaires d'ouverture du garage
        $openingHoursData = [
            ['Lundi', '08:00', '18:00'],
            ['Mardi', '08:00', '18:00'],
            ['Mercredi', '08:00', '18:00'],
            ['Jeudi', '08:00', '18:00'],
            ['Vendredi', '08:00', '18:00'],
            ['Samedi', '09:00', '16:00'],
            ['Dimanche', '12:00', '15:00']
        ];

        foreach ($openingHoursData as $hoursData) {
            $openingHour = new OpeningHours();
            $openingHour->setDay($hoursData[0])
                        ->setOpeningTime($hoursData[1] === 'Fermé' ? null : $hoursData[1])
                        ->setClosingTime($hoursData[2] === 'Fermé' ? null : $hoursData[2]);

            $manager->persist($openingHour);
        }


        // Création de 10 voitures avec Faker
        $faker = Factory::create();
        // Chemin relatif à l'intérieur du conteneur
        $imagesDir = __DIR__.'/public/uploads/';

        // Assurez-vous que le répertoire existe
        $filesystem = new Filesystem();
        if (!$filesystem->exists($imagesDir)) {
            throw new \RuntimeException("Le répertoire des images n'existe pas : $imagesDir");
        }

        // Obtenez la liste des fichiers d'images dans le répertoire
        $imageFiles = scandir($imagesDir);
        $imageFiles = array_diff($imageFiles, ['.', '..']); // Éliminez les entrées '.' et '..'

        for ($i = 0; $i < 10; $i++) {
            $car = new Car();
            $car->setPrice($faker->randomFloat(2, 5000, 50000));
            $car->setYear($faker->year);
            $car->setMileage($faker->numberBetween(10000, 200000));

            // Choisissez une image aléatoire du répertoire
            $randomImage = $faker->randomElement($imageFiles);
            $car->setMainImageFilename($randomImage);

            $car->setDescription($faker->paragraph);
            $car->setGallery([$faker->randomElement($imageFiles)]);
            $car->setFeatures(['Climatisation', 'GPS']);
            $car->setOptions(['ABS', 'Airbags']);

            $manager->persist($car);
        }

        // Flush pour sauvegarder les utilisateurs, services et horaires en base
        $manager->flush();
    }
}
