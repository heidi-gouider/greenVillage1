<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
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
}
