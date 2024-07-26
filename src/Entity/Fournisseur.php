<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_fournisseur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_fournisseur = null;

    #[ORM\Column(nullable: true)]
    private ?string $telephone_fournisseur = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'fournisseurs')]
    private Collection $produit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNomFournisseur(): ?string
    {
        return $this->nom_fournisseur;
    }

    public function setNomFournisseur(?string $nom_fournisseur): static
    {
        $this->nom_fournisseur = $nom_fournisseur;

        return $this;
    }

    public function getAdresseFournisseur(): ?string
    {
        return $this->adresse_fournisseur;
    }

    public function setAdresseFournisseur(?string $adresse_fournisseur): static
    {
        $this->adresse_fournisseur = $adresse_fournisseur;

        return $this;
    }

    public function getTelephoneFournisseur(): ?string
    {
        return $this->telephone_fournisseur;
    }

    public function setTelephoneFournisseur(?string $telephone_fournisseur): static
    {
        $this->telephone_fournisseur = $telephone_fournisseur;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produit->contains($produit)) {
            $this->produit->add($produit);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        $this->produit->removeElement($produit);

        return $this;
    }
}
