<?php

namespace App\DataFixtures;

use App\Entity\Distributeur;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class JoinDistributeurFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $repProduit = $manager->getRepository(Produit::class);

        // Création des distributeurs
        $logitech = new Distributeur();
        $logitech->setNom('Logitech');

        $hp = new Distributeur();
        $hp->setNom('HP');

        $epson = new Distributeur();
        $epson->setNom('Epson');

        $dell = new Distributeur();
        $dell->setNom('Dell');

        $acer = new Distributeur();
        $acer->setNom('Acer');

        $produits = [
            'souris' => [$hp, $logitech],
            'écrans' => [$hp, $dell],
            'claviers' => [$hp, $logitech],
            'ordinateurs' => [$hp, $dell, $acer],
            'cartouches encre' => [$epson],
            'imprimantes' => [$epson, $hp],
        ];

        foreach ($produits as $nomProduit => $distributeurs) {
            $produit = $repProduit->findOneBy(['nom' => $nomProduit]);
            if (!$produit) {
                throw new \Exception("Produit '$nomProduit' non trouvé !");
            }
            foreach ($distributeurs as $dist) {
                $produit->addDistributeur($dist);
            }
            $manager->persist($produit);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group3'];
    }
}
