<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[Vich\Uploadable]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $libelle_categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $description_categorie = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'categories')]
    // si une categorie parente est supprimée toutes les categories enfants le champ parent =null
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[Groups(['read'])]
    private ?self $parent_categorie = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent_categorie')]
    #[Groups(['read'])]
    private Collection $categories;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'categorie', cascade: ['persist'])]
    #[Groups(['read'])]
    private Collection $produits;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'parentCategorie')]
    #[Groups(['read', 'write'])]
    private Collection $produit;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $categorie_image = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $imagePath = null;

    // Ce champ ne sera pas persisté dans la base de données, il est utilisé pour l'upload
    #[Vich\UploadableField(mapping: 'categorie_image', fileNameProperty: 'imagePath')]
    private ?File $imageFile = null;

    // #[ORM\Column(type: 'datetime', nullable: true)]
    // private ?\DateTimeImmutable $updatedAt = null;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->produit = new ArrayCollection();
        // $this->commandes = new ArrayCollection();
        // $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCategorie(): ?string
    {
        return $this->libelle_categorie;
    }

    public function __toString(): string
    {
        return $this->libelle_categorie ?: 'Catégorie sans nom'; // Retourne le libellé ou une chaîne par défaut
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

    public function getImageCategorie ()
    {
        return $this->categorie_image;
    }

    public function setImageCategorie($categorie_image ): static
    {
        $this->categorie_image  = $categorie_image ;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
        //     if ($imageFile instanceof UploadedFile) {
            // Met à jour une propriété "updatedAt" pour forcer la mise à jour de l'entité
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}
