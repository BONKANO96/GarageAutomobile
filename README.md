# 🚗 Garage Vincent Parrot
Bienvenue sur le dépôt du site web du Garage Vincent Parrot, un projet de gestion de services automobiles comprenant la vente de voitures d'occasion, des services de réparation, et des témoignages clients.

# 📋 Description du projet
Le site web du Garage Vincent Parrot permet aux utilisateurs de consulter les services proposés par le garage, de visualiser les voitures d'occasion disponibles et d'obtenir des informations sur les horaires d'ouverture. Il est entièrement responsive et inclut diverses fonctionnalités pour améliorer l'expérience utilisateur :

### Gestion des horaires d'ouverture.
### Exposition de voitures d'occasion avec filtres dynamiques.
### Témoignages clients avec modération des commentaires.
### Section accessoires et services pour les véhicules des marques (VW, Audi, SEAT, CUPRA, SKODA).
### Interface administrateur pour ajouter, modifier ou supprimer des voitures et des témoignages.
### Intégration des réseaux sociaux pour suivre l'actualité du garage.
# 📂 Structure du projet
bash
Copier le code
├── assets/             # Fichiers de ressources (images, CSS, JS)
├── src/                # Dossier source de l'application Symfony
│   ├── Controller/      # Contrôleurs Symfony
│   ├── Entity/          # Entités Doctrine (voitures, témoignages, horaires)
│   ├── Form/            # Formulaires Symfony
│   ├── Repository/      # Repositories Doctrine
│   ├── Templates/       # Templates Twig pour l'UI
│   └── Service/         # Services pour la logique métier
├── templates/             # Fichiers de visualisation
├── tests/         # Fichiers de migration de la base de données
├── translations/             # Fichiers de traduction
└── README.md           # Documentation du projet
# 🔧 Technologies utilisées
### Symfony 6 : Framework PHP pour la gestion du backend.
### Doctrine ORM : Gestion des bases de données et des entités.
### Twig : Moteur de templates pour le rendu des pages.
### Bootstrap 5 : Pour le design responsive et les composants UI.
### JavaScript (ES6) : Pour l'interactivité et les filtres dynamiques.
### Font Awesome : Pour les icônes dans le header et footer.
### MySQL : Base de données pour stocker les informations sur les voitures, les témoignages, etc.
### Figma: Outils de design utilisés pour les maquettes et le prototypage.
# 📦 Installation
### Prérequis
##### PHP 8.1+
##### Composer installé.
##### nginx pour la gestion du serveur
##### MySQL pour la base de données.
### Étapes d'installation
##### Clonez le dépôt du projet aprés configuration de docker:
git clone https://github.com/votre-compte/garage-vincent-parrot.git
cd garage-vincent-parrot
##### Installez les dépendances PHP via Composer :
composer install
docker-compose up
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
(Optionnel) Chargez les fixtures pour initialiser des données de test :
php bin/console doctrine:fixtures:load

# 🚀 Fonctionnalités
### 1. Gestion des véhicules d'occasion
Affichage des voitures disponibles avec filtres par prix, kilométrage, et année.
Ajout, modification et suppression de véhicules par les employés du garage.
### 2. Gestion des horaires d'ouverture
Possibilité de modifier les horaires d'ouverture depuis l'espace administrateur.
Affichage dynamique des horaires sur toutes les pages du site.
### 3. Témoignages clients
Les visiteurs peuvent ajouter des commentaires après approbation par un administrateur.
Les administrateurs peuvent gérer les témoignages depuis un espace dédié.
### 4. Section accessoires
Visualisation des accessoires disponibles par marque.
Design adapté pour chaque marque (VW, Audi, SEAT, etc.).
# 🛠️ Développement
Branches
### main : Contient la dernière version stable du projet.
### dev : Contient les développements en cours.
Méthodologie Agile
Trello : Le projet est géré selon la méthode agile. Les tâches et US sont suivies sur un tableau Trello.
Tests
Tests unitaires et fonctionnels sont réalisés avec PHPUnit.
Lancer les tests :
php bin/phpunit
# ✨ Contributions
Les contributions sont les bienvenues ! Veuillez suivre les étapes ci-dessous pour soumettre une modification :

Forker le projet.
Créer une branche pour vos modifications : git checkout -b feature/ma-modification.
Commiter vos modifications : git commit -m 'Ajouter une fonctionnalité'.
Pousser vers votre branche : git push origin feature/ma-modification.
Ouvrir une Pull Request.
# 📜 Licence
Ce projet est sous licence MIT. Veuillez consulter le fichier LICENSE pour plus d'informations.

