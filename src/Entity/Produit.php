<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $photo = null;

    #[ORM\Column]
    private ?int $quantite_stock = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference_fournisseur = null;


    /**
     * @var Collection<int, Fournisseur>
     */
    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'produit')]
    private Collection $fournisseurs;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'sousRubriques')]
    private Collection $rubriques;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'rubriques')]
    private Collection $sousRubriques;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
        $this->rubriques = new ArrayCollection();
        $this->sousRubriques = new ArrayCollection();
    }

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

    public function getReferenceFournisseur(): ?string
    {
        return $this->reference_fournisseur;
    }

    public function setReferenceFournisseur(string $reference_fournisseur): static
    {
        $this->reference_fournisseur = $reference_fournisseur;

        return $this;
    }


    /**
     * @return Collection<int, Fournisseur>
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): static
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
            $fournisseur->addProduit($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): static
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeProduit($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRubriques(): Collection
    {
        return $this->rubriques;
    }

    public function addRubrique(self $rubrique): static
    {
        if (!$this->rubriques->contains($rubrique)) {
            $this->rubriques->add($rubrique);
        }

        return $this;
    }

    public function removeRubrique(self $rubrique): static
    {
        $this->rubriques->removeElement($rubrique);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSousRubriques(): Collection
    {
        return $this->sousRubriques;
    }

    public function addSousRubrique(self $sousRubrique): static
    {
        if (!$this->sousRubriques->contains($sousRubrique)) {
            $this->sousRubriques->add($sousRubrique);
            $sousRubrique->addRubrique($this);
        }

        return $this;
    }

    public function removeSousRubrique(self $sousRubrique): static
    {
        if ($this->sousRubriques->removeElement($sousRubrique)) {
            $sousRubrique->removeRubrique($this);
        }

        return $this;
    }
}
