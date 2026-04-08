# MonAppliSymf - Guide complet de prise en main

Ce README explique, de A a Z, comment installer, configurer et lancer l application en local, meme si vous partez de zero.

## 1) Presentation du projet

Application web Symfony avec:
- catalogue produits
- authentification (login/register/logout)
- administration des produits
- gestion des categories (many-to-many produit <-> categorie)
- filtre produits par categorie.

## 2) Stack technique

- PHP >= 8.2 (8.3 recommande)
- Symfony 7.3
- Doctrine ORM / Doctrine Migrations
- Twig + Bootstrap
- MySQL / MariaDB
- Composer
- (Optionnel) Symfony CLI

## 3) Prerequis machine

Installez avant toute chose:

1. **PHP** (`php -v`)
2. **Composer** (`composer -V`)
3. **Base de donnees** MySQL/MariaDB (WAMP/XAMPP/MAMP ou serveur local)
4. **Git** (si clonage du projet)
5. **Symfony CLI** (optionnel mais pratique) (`symfony -v`)

## 4) Recuperer le projet

Si vous clonez:

```bash
git clone <url-du-repo>
cd monAppliSymf
```

Si vous avez deja le dossier, placez-vous simplement a la racine du projet.

## 5) Installation des dependances

### 5.1 Dependances PHP

```bash
composer install
```

### 5.2 Dependances front (si necessaire)

Le projet peut fonctionner avec les assets deja presents. Si besoin:

```bash
npm install
```

## 6) Configuration environnement

### 6.1 Creer votre configuration locale

Copiez `.env` vers `.env.local` puis adaptez:

```bash
cp .env .env.local
```

Sous PowerShell:

```powershell
Copy-Item .env .env.local
```

### 6.2 Variables importantes

Dans `.env.local`:

- `APP_ENV=dev` (recommande en local)
- `APP_DEBUG=true`
- `DATABASE_URL` (connexion base)

Exemple MariaDB local:

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/monapplisymf?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

## 7) Base de donnees

### 7.1 Creation de la base

```bash
php bin/console doctrine:database:create
```

### 7.2 Migration schema

```bash
php bin/console doctrine:migrations:migrate
```

### 7.3 (Optionnel) Fixtures

```bash
php bin/console doctrine:fixtures:load
```

## 8) Lancer l application

### Option A - Symfony CLI

```bash
symfony serve
```

Puis ouvrir:
- [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Option B - PHP built-in server

```bash
php -S 127.0.0.1:8000 -t public
```

Puis ouvrir:
- [http://127.0.0.1:8000](http://127.0.0.1:8000)

## 9) Comptes et acces

### Utilisateur standard
- acces consultation catalogue
- filtre par categorie

### Admin (`ROLE_ADMIN`)
- ajout/modification/suppression produits
- gestion des categories (`/admin/categories`)

Si aucun compte n existe, creez-en un via `/register` puis ajustez le role en base si necessaire.

## 10) Parcours fonctionnel rapide

1. Aller sur `/liste`
2. Tester le filtre categorie
3. Se connecter (`/login`)
4. En admin:
   - ajouter une categorie
   - ajouter/modifier un produit avec une ou plusieurs categories
5. Revenir sur `/liste` et verifier les badges categories + filtre.

## 11) Commandes utiles

```bash
php bin/console about
php bin/console debug:router
php bin/console cache:clear
php bin/console lint:container
php bin/console lint:twig templates
php bin/phpunit
```

## 12) Depannage (important)

### Probleme cache (modifs non visibles)

Si vos changements Twig/controleur ne s affichent pas:

```bash
php bin/console cache:clear --env=prod
php bin/console cache:clear --env=dev
```

Puis hard refresh navigateur (`Ctrl+F5`).

### Erreur Doctrine/MariaDB sur `FULL_COLLATION_NAME`

Selon certaines versions WAMP + DBAL, `doctrine:migrations:*` peut echouer avec:
- `Column not found: ccsa.FULL_COLLATION_NAME`

Actions recommandees:
1. verifier `DATABASE_URL` et `serverVersion`
2. passer en `APP_ENV=dev` localement
3. relancer `cache:clear`
4. relancer la migration.

Si le probleme persiste sur votre environnement local, appliquez la migration SQL manuellement via:

```bash
php bin/console dbal:run-sql "<VOTRE SQL>"
```

## 13) Structure du projet

- `src/Controller`: endpoints HTTP
- `src/Entity`: entites Doctrine
- `src/Repository`: acces donnees
- `src/Form`: formulaires Symfony
- `templates`: vues Twig
- `config`: configuration application
- `migrations`: migrations base de donnees
- `public`: point d entree web
- `tests`: tests automatises
- `var`: cache/logs

## 14) Documentation complementaire

- `RAPPORT_EPREUVE.md`
- `DOCUMENTATION_UTILISATEUR.md`
- `DOCUMENTATION_TECHNIQUE.md`
- `DOCUMENTATION_TECHNIQUE_COMPLETE.md`
- `DOCUMENTATION_TECHNIQUE_CATEGORIES.md`
