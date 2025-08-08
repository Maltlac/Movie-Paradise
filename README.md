# Movie Paradise

Movie Paradise est une application Laravel de streaming de films et séries.

## Prérequis
- PHP 8.x
- Composer
- Node.js & npm
- Base de données compatible (MySQL, PostgreSQL, etc.)

## Installation
1. Cloner le dépôt :
   ```bash
   git clone <repo>
   cd Movie-Paradise
   ```
2. Installer les dépendances PHP :
   ```bash
   composer install
   ```
3. Installer les dépendances front :
   ```bash
   npm install
   ```
4. Copier le fichier `.env.example` vers `.env` et configurer la base de données.
5. Générer la clé de l'application :
   ```bash
   php artisan key:generate
   ```
6. Lancer les migrations :
   ```bash
   php artisan migrate
   ```
7. Démarrer le serveur de développement :
   ```bash
   php artisan serve
   ```

## Tests
Les tests automatisés peuvent être lancés avec :
```bash
php artisan test
```

## Contribution
Les contributions sont les bienvenues. Merci de proposer une *pull request* pour toute amélioration.
