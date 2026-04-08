# Documentation technique - Gestion des categories

## 1. Objectif
Mettre en place une gestion des categories permettant:
- de creer des categories en administration
- d associer une ou plusieurs categories a un produit
- d afficher ces categories dans la liste produits
- de filtrer les produits par categorie.

## 2. Conception de donnees

### 2.1 Entite `Categorie`
Fichier: `src/Entity/Categorie.php`

Attributs:
- `id` (PK, auto-increment)
- `nom` (string, unique)

Relation:
- inverse d un ManyToMany avec `Produit`.

### 2.2 Evolution de `Produit`
Fichier: `src/Entity/Produit.php`

Ajouts:
- propriete `categories` (collection)
- methodes `getCategories`, `addCategorie`, `removeCategorie`
- initialisation de la collection dans le constructeur.

### 2.3 Schema SQL
Migration: `migrations/Version20260408123800.php`

Objets crees:
- table `categorie`
- table de jointure `produit_categorie`
- index et foreign keys vers `produit` et `categorie`.

## 3. Couche formulaire

### 3.1 `CategorieType`
Fichier: `src/Form/CategorieType.php`

- champ `nom`
- contraintes de validation:
  - obligatoire (`NotBlank`)
  - longueur max 255 (`Length`).

### 3.2 `ProduitType`
Fichier: `src/Form/ProduitType.php`

Ajout du champ:
- `categories` (EntityType)
  - source: `Categorie::class`
  - affichage: `nom`
  - `multiple: true`
  - `required: false`.

## 4. Couche controleur

### 4.1 Administration des categories
Fichier: `src/Controller/CategorieController.php`

Routes:
- `GET|POST /admin/categories` (`admin_categories`)
  - liste des categories
  - ajout categorie
- `POST /admin/categories/delete/{id}` (`admin_categories_delete`)
  - suppression categorie avec token CSRF.

Securite:
- `#[IsGranted('ROLE_ADMIN')]`.

### 4.2 Filtre des produits par categorie
Fichier: `src/Controller/ListeProduitsController.php`

Logique:
- lecture du parametre GET `categorie`
- chargement des categories pour alimenter le select
- si categorie renseignee:
  - jointure + clause `WHERE` sur l id categorie
- sinon:
  - affichage complet des produits.

## 5. Couche vue

### 5.1 Vue gestion categories
Fichier: `templates/categorie/index.html.twig`

Contenu:
- formulaire d ajout
- liste des categories
- bouton de suppression.

### 5.2 Vue liste produits
Fichier: `templates/liste_produits/index.html.twig`

Contenu categories:
- affichage badges categories sur chaque produit
- bloc de filtre:
  - select categories
  - bouton `Filtrer`
  - bouton `Reinitialiser`
  - affichage du filtre actif.

## 6. Verification technique conseillee

1. `php bin/console cache:clear`
2. `php bin/console lint:container`
3. `php bin/console lint:twig templates/liste_produits/index.html.twig templates/categorie/index.html.twig`
4. verifier en UI:
   - creation categorie
   - edition produit avec 1..n categories
   - filtrage par categorie.

## 7. Risques et points d attention
- cache Twig en `prod` pouvant masquer des changements de vue recents
- suppression categorie a valider selon politique metier (actuellement suppression du lien via FK CASCADE sur la table de jointure)
- coherence des donnees si import massif de produits/categories.
