# Rapport d epreuve - Gestion des categories

## Contexte
Le besoin client etait d ajouter une gestion des categories pour les produits, avec la regle suivante: un produit peut appartenir a plusieurs categories.

## Travaux realises
### 1) Evolution du modele de donnees
- Creation de l entite `Categorie` avec les attributs:
  - `id` (cle primaire)
  - `nom` (unique)
- Ajout d une relation `ManyToMany` entre `Produit` et `Categorie`.
- Generation de la migration Doctrine `Version20260408123800` pour:
  - creer la table `categorie`
  - creer la table de jointure `produit_categorie`
  - poser les cles et contraintes d integrite.
- Execution de la migration avec Doctrine afin de mettre a jour la base.

### 2) Mise en place de la regle de gestion
- Creation du formulaire `CategorieType` pour creer une categorie.
- Modification du formulaire `ProduitType` pour selectionner une ou plusieurs categories.
- Creation du controleur `CategorieController` (acces admin) avec:
  - affichage de la liste des categories
  - ajout d une categorie
  - suppression d une categorie.
- Creation de la vue `templates/categorie/index.html.twig`.
- Modification de la vue `templates/liste_produits/index.html.twig`:
  - ajout d un bouton "Gerer les categories" pour les admins
  - affichage des categories associees a chaque produit.
- Ajout d un filtre par categorie sur la liste produits:
  - affichage par defaut de tous les produits
  - filtrage des produits appartenant a une categorie choisie
  - bouton de reinitialisation du filtre.

## Difficultes rencontrees
- Ajustement de la modelisation pour respecter la regle de gestion "un produit peut appartenir a plusieurs categories".
- Verification de la coherence entre entites, formulaire produit et affichage de la vue liste produits.

## Resultat
La fonctionnalite demandee est en place:
- gestion des categories cote admin,
- association multiple categorie <-> produit,
- affichage des categories sur la liste produits,
- filtrage des produits par categorie avec affichage de tous les produits par defaut.
