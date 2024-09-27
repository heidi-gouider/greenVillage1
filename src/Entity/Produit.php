<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
// use Doctrine\DBAL\Types\Types;
// use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle_produit = null;

    #[ORM\Column(length: 255)]
    private ?string $description_produit = null;

    #[ORM\Column]
    private ?int $prix_achat_ht = null;

    #[ORM\Column(type: 'integer', precision: 10, nullable: true)]
    private ?int $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?int $quantite_stock = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_ht = null;


    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $reference_fournisseur = null;

    // /**
    //  * @var Collection<int, Fournisseur>
    //  */
    // #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'produit')]
    // private Collection $fournisseurs;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $parentCategorie = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    private Collection $commandes;

    #[ORM\Column(nullable: true)]
    private ?int $quantite_vendu = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Detail::class)]
    private Collection $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    // public function __construct()
    // {
    //     $this->fournisseurs = new ArrayCollection();
    //     $this->categorie = new ArrayCollection();
    //     $this->commandes = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleProduit(): ?string
    {
        return $this->libelle_produit;
    }

    public function setLibelleProduit(string $libelle_produit): static
    {
        $this->libelle_produit = $libelle_produit;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->description_produit;
    }

    public function setDescriptionProduit(string $description_produit): static
    {
        $this->description_produit = $description_produit;

        return $this;
    }

    public function getPrixAchatHt(): ?int
    {
        return $this->prix_achat_ht;
    }

    public function setPrixAchatHt(int $prix_achat_ht): static
    {
        $this->prix_achat_ht = $prix_achat_ht;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantite_stock;
    }

    public function setQuantiteStock(int $quantite_stock): static
    {
        $this->quantite_stock = $quantite_stock;

        return $this;
    }

    public function getTotalHt()
    {
        return $this->total_ht;
    }

    public function setTotalHt($total_ht): static
    {
        $this->total_ht = $total_ht;

        return $this;
    }

    // public function getReferenceFournisseur(): ?string
    // {
    //     return $this->reference_fournisseur;
    // }

    // public function setReferenceFournisseur(string $reference_fournisseur): static
    // {
    //     $this->reference_fournisseur = $reference_fournisseur;

    //     return $this;
    // }


    // /**
    //  * @return Collection<int, Fournisseur>
    //  */
    // public function getFournisseurs(): Collection
    // {
    //     return $this->fournisseurs;
    // }

    // public function addFournisseur(Fournisseur $fournisseur): static
    // {
    //     if (!$this->fournisseurs->contains($fournisseur)) {
    //         $this->fournisseurs->add($fournisseur);
    //         $fournisseur->addProduit($this);
    //     }

    //     return $this;
    // }

    // public function removeFournisseur(Fournisseur $fournisseur): static
    // {
    //     if ($this->fournisseurs->removeElement($fournisseur)) {
    //         $fournisseur->removeProduit($this);
    //     }

    //     return $this;
    // }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getParentCategorie(): ?Categorie
    {
        return $this->parentCategorie;
    }

    public function setParentCategorie(?Categorie $parentCategorie): static
    {
        $this->parentCategorie = $parentCategorie;

        return $this;
    }

    // /**
    //  * @return Collection<int, Commande>
    //  */
    // public function getCommandes(): Collection
    // {
    //     return $this->commandes;
    // }

    // public function addCommande(Commande $commande): static
    // {
    //     if (!$this->commandes->contains($commande)) {
    //         $this->commandes->add($commande);
    //         $commande->addProduit($this);
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): static
    // {
    //     if ($this->commandes->removeElement($commande)) {
    //         $commande->removeProduit($this);
    //     }

    //     return $this;
    // }

    public function getQuantiteVendu(): ?int
    {
        return $this->quantite_vendu;
    }

    public function setQuantiteVendu(?int $quantite_vendu): static
    {
        $this->quantite_vendu = $quantite_vendu;

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setproduit($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getproduit() === $this) {
                $detail->setproduit(null);
            }
        }

        return $this;
    }


    
}
