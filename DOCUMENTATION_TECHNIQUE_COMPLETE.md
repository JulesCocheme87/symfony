# Documentation technique complete - Application Symfony

## 1. Presentation generale

### 1.1 Objectif
Cette application Symfony permet:
- l affichage d un catalogue de produits
- la gestion des comptes utilisateurs et des roles
- l administration des produits
- l administration des categories
- le filtrage des produits par categorie.

### 1.2 Stack technique
- PHP 8.3
- Symfony 7.3
- Doctrine ORM + Doctrine Migrations
- Twig
- Bootstrap
- Base de donnees MySQL/MariaDB

## 2. Architecture du projet

### 2.1 Organisation principale
- `src/Controller`: controleurs HTTP
- `src/Entity`: modeles Doctrine
- `src/Repository`: acces aux donnees
- `src/Form`: formulaires Symfony
- `templates`: vues Twig
- `migrations`: migrations SQL Doctrine
- `config`: configuration Symfony/Doctrine/Securite

### 2.2 Flux applicatif
1. Une route HTTP appelle un controleur.
2. Le controleur charge/filtre les donnees via Doctrine.
3. Les donnees sont injectees dans une vue Twig.
4. En cas de formulaire valide, le controleur persiste les entites via l EntityManager.

## 3. Couche donnees (modele)

### 3.1 Entites principales
- `Produit`: informations du produit (nom, prix, quantite, description, rupture, image)
- `Categorie`: categorie de classement
- `Distributeur`: fournisseur/distributeur de produits
- `User`: compte applicatif et roles

### 3.2 Relations
- `Produit` <-> `Categorie`: ManyToMany
- `Produit` <-> `Distributeur`: ManyToMany

### 3.3 Migrations
- Migration categories: `migrations/Version20260408123800.php`
  - table `categorie`
  - table de jointure `produit_categorie`
  - contraintes de cle et index.

## 4. Couche presentation (Twig)

### 4.1 Gabarits
- `templates/base.html.twig`: layout global
- `templates/header.html.twig` et `templates/footer.html.twig`: zones communes
- `templates/alert.html.twig`: affichage des messages flash

### 4.2 Vues metier
- `templates/liste_produits/index.html.twig`: liste principale + filtre categorie
- `templates/admin/create.html.twig`: creation produit
- `templates/admin/update.html.twig`: edition produit
- `templates/categorie/index.html.twig`: gestion categories
- `templates/security/login.html.twig`: connexion
- `templates/register/index.html.twig`: inscription

## 5. Routes et controleurs

### 5.1 Catalogue / utilisateur
- `/` -> `HomeController::index`
- `/liste` -> `ListeProduitsController::index`
  - parametre GET `categorie` pour filtrer
- `/login` -> `SecurityController::login`
- `/logout` -> `SecurityController::logout`
- `/register` -> `RegisterController::register`

### 5.2 Administration
- `/admin/insert` -> `AdminController::insert` (ROLE_ADMIN)
- `/admin/update/{id}` -> `AdminController::update` (ROLE_ADMIN)
- `/admin/delete/{id}` -> `AdminController::delete` (ROLE_ADMIN)
- `/admin/categories` -> `CategorieController::index` (ROLE_ADMIN)
- `/admin/categories/delete/{id}` -> `CategorieController::delete` (ROLE_ADMIN)

### 5.3 Routes techniques/complementaires
- `/distrib`, `/eager`, `/apitest`, `/chart`, `/test`, `/hello/...`, `/email`

## 6. Formulaires

### 6.1 Produit
Formulaire `ProduitType`:
- champs metier produit
- champ `categories` de type `EntityType`
  - `multiple: true`
  - `choice_label: nom`

### 6.2 Categorie
Formulaire `CategorieType`:
- champ `nom`
- contraintes:
  - `NotBlank`
  - `Length(max: 255)`

### 6.3 Register
Formulaire construit dans le controleur:
- username
- mot de passe repete
- roles (multiple)

## 7. Securite

### 7.1 Authentification
- Form login via `SecurityController`.

### 7.2 Autorisations
- Controle d acces admin via attribut:
  - `#[IsGranted('ROLE_ADMIN')]` sur les controleurs d administration.

## 8. Focus technique: gestion des categories

### 8.1 Besoin metier
Un produit peut appartenir a plusieurs categories.

### 8.2 Implementation
- Entite `Categorie`
- Relation ManyToMany `Produit` <-> `Categorie`
- Ajout du champ categories dans `ProduitType`
- Ecran admin dedie pour CRUD partiel categories (create/list/delete)
- Affichage des categories sur chaque carte produit
- Filtre des produits par categorie via query string.

### 8.3 Requete de filtrage
Dans `ListeProduitsController::index`:
- sans parametre: tous les produits
- avec `?categorie=<id>`: jointure sur `p.categories` et filtre sur l id categorie.

### 8.4 Validation fonctionnelle attendue
- creer categories
- affecter une ou plusieurs categories a un produit
- retrouver les badges categories en liste
- filtrer les produits par categorie
- reinitialiser le filtre vers l affichage complet.

## 9. Exploitation et maintenance

### 9.1 Commandes utiles
- `php bin/console cache:clear`
- `php bin/console doctrine:migrations:migrate`
- `php bin/console lint:container`
- `php bin/console lint:twig templates`

### 9.2 Points de vigilance
- vider le cache en environnement `prod` apres modification Twig
- verifier les roles pour les routes admin
- maintenir la coherence des relations many-to-many lors des evolutions.

## 10. Plan de tests techniques recommande
- test routes principales (200/302/403 attendus selon role)
- test creation/modification/suppression produit
- test creation/suppression categorie
- test association multi-categories
- test filtre categorie et reset
- test endpoint JSON `/apitest`.
