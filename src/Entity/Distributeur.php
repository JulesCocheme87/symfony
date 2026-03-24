<?php

namespace App\Entity;

use App\Repository\DistributeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;

#[ORM\Entity(repositoryClass: DistributeurRepository::class)]
class Distributeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    // Relation inverse ManyToMany
    /**
     * @var Collection<int, Produit>
     */
    #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: "distributeurs")]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    // --- Getters et setters ---
    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection { return $this->produits; }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            // NE PAS appeler $produit->addDistributeur($this) pour éviter boucle infinie
        }
        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
        }
        return $this;
    }
}
