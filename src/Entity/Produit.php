<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Distributeur;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'float')]
    private ?float $prix = null;

    #[ORM\Column(type: 'integer')]
    private ?int $quantite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienImage = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $rupture = null;

    /**
     * @var Collection<int, Distributeur>
     */
    #[ORM\ManyToMany(targetEntity: Distributeur::class, inversedBy: "produits")]
    private Collection $distributeurs;

    public function __construct()
    {
        $this->distributeurs = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function getPrix(): ?float { return $this->prix; }
    public function setPrix(float $prix): static { $this->prix = $prix; return $this; }

    public function getQuantite(): ?int { return $this->quantite; }
    public function setQuantite(int $quantite): static { $this->quantite = $quantite; return $this; }

    public function getLienImage(): ?string { return $this->lienImage; }
    public function setLienImage(?string $lienImage): static { $this->lienImage = $lienImage; return $this; }

    public function isRupture(): ?bool { return $this->rupture; }
    public function setRupture(bool $rupture): static { $this->rupture = $rupture; return $this; }

    /**
     * @return Collection<int, Distributeur>
     */
    public function getDistributeurs(): Collection { return $this->distributeurs; }

    public function addDistributeur(Distributeur $distributeur): static
    {
        if (!$this->distributeurs->contains($distributeur)) {
            $this->distributeurs->add($distributeur);
        }
        return $this;
    }

    public function removeDistributeur(Distributeur $distributeur): static
    {
        $this->distributeurs->removeElement($distributeur);
        return $this;
    }
}
