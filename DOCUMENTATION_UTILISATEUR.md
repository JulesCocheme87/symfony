# Documentation utilisateur - Application complete

## Objectif de l application
L application permet d afficher un catalogue de produits, de gerer l authentification des utilisateurs, et de proposer des fonctions d administration (produits et categories) selon les droits.

## Prerequis
- Navigateur web
- Acces a l URL de l application
- Compte utilisateur pour se connecter
- Compte avec role `ROLE_ADMIN` pour les fonctions d administration

## Partie utilisateur (non-admin)

### 1) Accueil et consultation des produits
1. Ouvrir la page d accueil (`/`) ou la liste produits (`/liste`).
2. Consulter les cartes produits:
   - nom
   - prix
   - quantite ou statut de rupture
   - description (si renseignee)
   - categories associees.
3. Une zone promotionnelle peut afficher un produit mis en avant.

### 2) Filtrer les produits par categorie
1. Sur la page liste produits, utiliser le bloc `Filtrer par categorie`.
2. Choisir une categorie dans la liste.
3. Cliquer sur `Filtrer` pour n afficher que les produits de la categorie.
4. Cliquer sur `Reinitialiser` (ou choisir `Toutes les categories`) pour revenir a la liste complete.

### 3) Connexion et deconnexion
1. Aller sur `/login`.
2. Saisir l identifiant et le mot de passe.
3. Valider pour ouvrir la session.
4. Pour se deconnecter, utiliser la route `/logout` (selon le lien present dans l interface).

### 4) Inscription
1. Aller sur `/register`.
2. Renseigner:
   - username
   - mot de passe + confirmation
   - role(s) (selon droits accordes par l organisation).
3. Valider le formulaire pour creer le compte.

## Partie admin

### 1) Gestion des produits
Les actions suivantes sont reservees a un compte `ROLE_ADMIN`.

#### Ajouter un produit
1. Aller sur `/liste`.
2. Cliquer sur `+ Ajouter un produit`.
3. Remplir les champs:
   - nom, prix, quantite
   - lien image (optionnel)
   - description (optionnel)
   - rupture
   - categories (une ou plusieurs).
4. Valider.

#### Modifier un produit
1. Sur `/liste`, cliquer sur `Modifier` sur le produit souhaite.
2. Mettre a jour les informations.
3. Valider `Mise a jour du produit`.

#### Supprimer un produit
1. Sur `/liste`, cliquer sur `Supprimer`.
2. Confirmer la suppression.

### 2) Gestion des categories
1. Aller sur `/admin/categories` (ou bouton `Gerer les categories` depuis `/liste`).
2. Ajouter une categorie:
   - saisir le nom
   - cliquer `Ajouter la categorie`.
3. Supprimer une categorie:
   - cliquer `Supprimer` en face de la categorie
   - confirmer.

### 3) Lien produits/categories
- Un produit peut etre associe a plusieurs categories.
- Une categorie peut contenir plusieurs produits.
- La suppression d une categorie supprime le lien avec les produits, sans supprimer les produits.

## Fonctions complementaires presentes dans l application
Ces ecrans existent pour tests ou usages techniques:
- `/distrib`: affichage des distributeurs
- `/chart`: page de graphique
- `/test` et `/hello/{age}/{nom}/{prenom}`: pages de demonstration
- `/email`: envoi d un email de test
- `/apitest`: endpoint JSON listant les noms des produits

## Messages et comportement attendus
- En cas de succes (ajout/modification/suppression), un message flash est affiche.
- En cas d acces non autorise a une page admin, l acces est refuse.
- Si aucun produit n est disponible, un message `Aucun produit pour le moment...` est affiche.
