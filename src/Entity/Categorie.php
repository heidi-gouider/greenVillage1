<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiRessource]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle_categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description_categorie = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'categories')]
    // si une categorie parente est supprimée toutes les categories enfants le champ parent =null
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?self $parent_categorie = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent_categorie')]
    private Collection $categories;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'categorie', cascade: ['persist'])]
    private Collection $produits;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'parentCategorie')]
    private Collection $produit;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_categorie = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCategorie(): ?string
    {
        return $this->libelle_categorie;
    }

    public function setLibelleCategorie(?string $libelle_categorie): static
    {
        $this->libelle_categorie = $libelle_categorie;

        return $this;
    }

    public function getDescriptionCategorie(): ?string
    {
        return $this->description_categorie;
    }

    public function setDescriptionCategorie(?string $description_categorie): static
    {
        $this->description_categorie = $description_categorie;

        return $this;
    }

    public function getParentCategorie(): ?self
    {
        return $this->parent_categorie;
    }

    public function setParentCategorie(?self $parent_categorie): static
    {
        $this->parent_categorie = $parent_categorie;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setParentCategorie($this);
        }

        return $this;
    }

    public function removeCategory(self $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getParentCategorie() === $this) {
                $category->setParentCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorie() === $this) {
                $produit->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    // public function getProduit(): Collection
    // {
    //     return $this->produit;
    // }

    public function getImageCategorie()
    {
        return $this->image_categorie;
    }

    public function setImageCategorie($image_categorie): static
    {
        $this->image_categorie = $image_categorie;

        return $this;
    }
}
