<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\ProduitRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        $produitEnPromotion = $produitRepository->getLastProduit();

        return $this->render('liste_produits/index.html.twig', [
            'listeproduits' => $produits,
            'lastproduit' => $produitEnPromotion,
        ]);
    }
}
