# MonAppliSymf

Bienvenue sur le projet **MonAppliSymf** ! Il s'agit d'une application web développée avec le framework Symfony 7.3.

## Technologies Principales

* **Framework :** Symfony 7.3
* **Langage :** PHP 8.2+
* **Base de données :** Doctrine ORM
* **Frontend :** Twig, Symfony UX (Turbo, React, Chart.js), AssetMapper
* **Tests :** PHPUnit

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

* PHP 8.2 ou supérieur
* Composer
* Un serveur de base de données (MySQL, PostgreSQL, etc.) ou SQLite
* Symfony CLI (recommandé pour le serveur de développement)

## Installation & Lancement

Suivez ces étapes pour configurer et lancer le projet localement :

1. **Cloner le projet** (si ce n'est pas déjà fait) :
   ```bash
   git clone <url-du-repo>
   cd monAppliSymf
   ```

2. **Installer les dépendances PHP** :
   ```bash
   composer install
   ```

3. **Configurer l'environnement** :
   Copiez le fichier `.env` pour créer vos variables locales :
   ```bash
   cp .env .env.local
   ```
   > N'oubliez pas de configurer la variable `DATABASE_URL` dans le fichier `.env.local` pour vous connecter à votre base de données locale.

4. **Créer la base de données et exécuter les migrations** :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
   *(Si votre projet utilise des fixtures, vous pouvez les charger avec `php bin/console doctrine:fixtures:load`)*

5. **Démarrer le serveur de développement** :
   ```bash
   symfony server:start -d
   ```
   L'application sera alors accessible à l'adresse suivante : [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Structure Principale du Projet

* `bin/` : Contient les exécutables (ex: la console Symfony).
* `config/` : Configuration globale de l'application (routes, services, bundles).
* `migrations/` : Fichiers de migration de la base de données.
* `public/` : Point d'entrée public de l'application (`index.php`) et assets exposés.
* `src/` : Code source métier de l'application (Controllers, Entities, Formulaires, Repositories...).
* `templates/` : Vues Twig de l'application.
* `tests/` : Fichiers de tests (PHPUnit).
* `var/` : Fichiers générés automatiquement par l'application (cache, logs).
* `vendor/` : Bibliothèques tierces gérées par Composer.

## Tests

Pour exécuter la suite de tests automatisés :
```bash
php bin/phpunit
```

---
