<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mode_reglement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_reglement = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_expedition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference_commande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_livraison = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_facturation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_client = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Utilisateur $Utilisateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_produit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantite_produit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $total_ht = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Detail::class)]
    private Collection $details;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    private Collection $produits;

    public function __construct()
    {
                // Initialisation de la collection de produits et de détails
        $this->produits = new ArrayCollection();
        $this->details = new ArrayCollection(); // Ajout de l'initialisation ici
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(?\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getModeReglement(): ?string
    {
        return $this->mode_reglement;
    }

    public function setModeReglement(?string $mode_reglement): static
    {
        $this->mode_reglement = $mode_reglement;

        return $this;
    }

    public function getDateReglement(): ?string
    {
        return $this->date_reglement;
    }

    public function setDateReglement(?string $date_reglement): static
    {
        $this->date_reglement = $date_reglement;

        return $this;
    }

    public function getNbExpedition(): ?int
    {
        return $this->nb_expedition;
    }

    public function setNbExpedition(?int $nb_expedition): static
    {
        $this->nb_expedition = $nb_expedition;

        return $this;
    }

    public function getReferenceCommande(): ?string
    {
        return $this->reference_commande;
    }

    public function setReferenceCommande(?string $reference_commande): static
    {
        $this->reference_commande = $reference_commande;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresse_livraison;
    }

    public function setAdresseLivraison(?string $adresse_livraison): static
    {
        $this->adresse_livraison = $adresse_livraison;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresse_facturation;
    }

    public function setAdresseFacturation(?string $adresse_facturation): static
    {
        $this->adresse_facturation = $adresse_facturation;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresse_client;
    }

    public function setAdresseClient(?string $adresse_client): static
    {
        $this->adresse_client = $adresse_client;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): static
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(?string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getQuantiteProduit(): ?string
    {
        return $this->quantite_produit;
    }

    public function setQuantiteProduit(?string $quantite_produit): static
    {
        $this->quantite_produit = $quantite_produit;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setCommande($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getCommande() === $this) {
                $detail->setCommande(null);
            }
        }
    }
    public function getTotalHT(): ?int
    {
        return $this->total_ht;
    }

    public function setTotalHT(?string $totalHT): static
    {
        $this->total_ht = $totalHT;

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
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    //  /**
    //  * @return Collection<int, Detail>
    //  */
    // public function getDetails(): Collection
    // {
    //     return $this->details;
    // }

        
    
}
