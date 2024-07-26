<?php

namespace App\Entity;

use App\Repository\ProduitCategorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitCategorieRepository::class)]
class ProduitCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rubrique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sous_rubrique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRubrique(): ?string
    {
        return $this->rubrique;
    }

    public function setRubrique(?string $rubrique): static
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    public function getSousRubrique(): ?string
    {
        return $this->sous_rubrique;
    }

    public function setSousRubrique(?string $sous_rubrique): static
    {
        $this->sous_rubrique = $sous_rubrique;

        return $this;
    }
}
