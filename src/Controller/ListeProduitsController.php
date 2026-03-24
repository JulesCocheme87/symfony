<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Distributeur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListeProduitsController extends AbstractController
{
    #[Route('/liste', name: 'liste_produits', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager->getRepository(Produit::class)->findAll();

        // Gestion du cas où il n'y a aucun produit
        $produitEnPromotion = $produits ? end($produits) : null;

        return $this->render('liste_produits/index.html.twig', [
            'listeproduits' => $produits,
            'lastproduit' => $produitEnPromotion,
        ]);
    }

    #[Route('/distrib', name: 'distributeurs', methods: ['GET'])]
    public function listedistributeur(EntityManagerInterface $entityManager): Response
    {
        $distributeurs = $entityManager
            ->getRepository(Distributeur::class)
            ->findAll();

        return $this->render('liste_produits/distributeurs.html.twig', [
            'distributeurs' => $distributeurs,
        ]);
    }

    #[Route('/eager', name: 'eager_loading_test', methods: ['GET'])]
    public function eager(EntityManagerInterface $entityManager): Response
    {
        // Variante avec eager loading (exemple) - utile pour tester les relations
        $produits = $entityManager
            ->getRepository(Produit::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.distributeurs', 'd')
            ->addSelect('d')           // eager loading des distributeurs
            ->getQuery()
            ->getResult();

        return $this->render('liste_produits/eager.html.twig', [
            'listeproduits' => $produits,
        ]);
    }
    #[Route("/apitest", name: "apitest")]
    public function apiTest(EntityManagerInterface $entityManager): JsonResponse
    {
        $produitsRepository = $entityManager->getRepository(Produit::class);
        $listeProduits = $produitsRepository->findAll();
        $resultat = [];
        foreach ($listeProduits as $produit) {
            $resultat[] = $produit->getNom();
        }
        return new JsonResponse($resultat);
    }
}
