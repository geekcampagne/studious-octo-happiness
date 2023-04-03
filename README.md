# Test Technique KeyProd

## Installation

### Prérequis

- PHP 8.2
- Composer
- Docker
- Docker-compose

### Dépendances

- Laravel 10
- Vue 3
- Vuetify 3
- Mysql

### Installation

- Cloner le projet

#### Configuration - Solution 1

- make up

#### Configuration - Solution 2

- Copier le fichier .env.example en .env
- Lancer la commande `composer install`
- Lancer la commande `sail up -d`
- Lancer la commande `sail php artisan key:generate`
- Lancer la commande `sail npm install`
- Lancer la commande `sail npm run build`
- Lancer la commande `sail php artisan migrate:fresh --seed`

### Accès

- L'application est accessible à l'adresse `http://localhost:8090`

## Frontend

L'ensemble des fichiers vues / vuetify se trouvent dans le dossier `resources/js`

La page `Listing.vue` est la page principale de l'application qui liste les commandes en utilisant le composant v-data-table-server pour gérer un volume de données potentiellement plus important

La page `Order.vue` est la page de détail d'une commande qui affiche les détails de la commande, les produits associés et qui permet les différentes actions demandés

- Scan d'un produit pour affecter le numéro de série à la commande
- Affectation d'un produit à un colis
- Création d'un colis
- Expedition d'un colis avec suivi)

## Backend

Le backend ne sert essentiellement que pour générer les datas (Factory & Seeder) dans le dossier database/factories et database/seeds

Les contollers dans le dossier app/Http/Controllers ne servent qu'à récupérer les données et les envoyer au frontend (et à traiter les données envoyées par le frontend mais sans contrôle/cohérence de données)
