<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/categories')]
#[IsGranted('ROLE_ADMIN')]
class CategorieController extends AbstractController
{
    #[Route('', name: 'admin_categories', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->add('creer', SubmitType::class, ['label' => 'Ajouter la categorie']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'Categorie ajoutee avec succes.');

            return $this->redirectToRoute('admin_categories');
        }

        $categories = $entityManager->getRepository(Categorie::class)->findBy([], ['nom' => 'ASC']);

        return $this->render('categorie/index.html.twig', [
            'my_form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_categorie_'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'Categorie supprimee avec succes.');
        }

        return $this->redirectToRoute('admin_categories');
    }
}
