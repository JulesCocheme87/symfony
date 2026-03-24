<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/insert', name: 'admin_insert')]
    public function insert(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();

        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->add('creer', SubmitType::class, [
            'label' => 'Insertion d\'un produit',
            'validation_groups' => ['registration', 'all']
        ]);

        $formProduit->handleRequest($request);

        if ($formProduit->isSubmitted() && $formProduit->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            $this->addFlash('success', 'Produit ajouté avec succès !');

            return $this->redirectToRoute('liste_produits');
        }

        return $this->render('admin/create.html.twig', [
            'my_form' => $formProduit->createView()
        ]);
    }

    #[Route('/update/{id}', name: 'admin_update')]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $produit = $entityManager->getRepository(Produit::class)->find($id);

        if (!$produit) {
            throw $this->createNotFoundException("Produit non trouvé");
        }

        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->add('creer', SubmitType::class, [
            'label' => 'Mise à jour du produit',
            'validation_groups' => ['all']
        ]);

        $formProduit->handleRequest($request);

        if ($formProduit->isSubmitted() && $formProduit->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Produit modifié avec succès !');

            return $this->redirectToRoute('liste_produits');
        }

        return $this->render('admin/update.html.twig', [
            'my_form' => $formProduit->createView(),
            'produit' => $produit
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $produit = $entityManager->getRepository(Produit::class)->find($id);

        if (!$produit) {
            throw $this->createNotFoundException("Produit non trouvé");
        }

        if ($this->isCsrfTokenValid('delete_'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();

            $this->addFlash('success', 'Produit supprimé avec succès !');
        }

        return $this->redirectToRoute('liste_produits');
    }
}
