<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiRessource]
class Commande
{
    // Déclaration des différents états de la commande
    const ETAT_ENREGISTREE_PAYEE = 0;
    const ETAT_EN_PREPARATION = 1;
    const ETAT_EN_COURS_DE_LIVRAISON = 2;
    const ETAT_LIVREE = 3;
    const ETAT_EN_ERREUR = 4;

    // Statuts de paiement
    const STATUT_NON_PAYE = 0;
    const STATUT_PAYE = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mode_reglement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_reglement = null;

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

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column]
    private ?int $etat = null;

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
        $this->created_at = new \DateTimeImmutable();
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

    public function getDateReglement(): ?\DateTimeInterface
    {
        return $this->date_reglement;
    }

    public function setDateReglement(?\DateTimeInterface $date_reglement): static
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

    // Méthodes pour obtenir le libellé du statut de paiement
    public static function getStatutLibelle(int $status): string
    {
        switch ($status) {
            case self::STATUT_PAYE:
                return 'Payé';
            case self::STATUT_NON_PAYE:
                return 'Non payé';
            default:
                return 'Statut inconnu';
        }
    }
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

     // Méthode pour obtenir le libellé de l'état
     public static function getEtatLibelle(int $etat): string
     {
         switch ($etat) {
             case self::ETAT_ENREGISTREE_PAYEE:
                 return 'enregistrée/payée';
             case self::ETAT_EN_PREPARATION:
                 return 'en préparation';
             case self::ETAT_EN_COURS_DE_LIVRAISON:
                 return 'en cours de livraison';
             case self::ETAT_LIVREE:
                 return 'livrée';
                 case self::ETAT_EN_ERREUR:
                    return 'en erreur';
             default:
                 return 'état inconnu';
         }
     }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): static
    {
        $this->etat = $etat;

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
        
    
}
