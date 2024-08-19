<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types; // Ajoute cette ligne
use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $objet = null;

    #[Assert\Email(
        message: 'Format  email invalide.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    // ajout d'un message pour rendre obligatoire le champ
    #[Assert\NotBlank(message: 'Le message est obligatoire.')]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }
    // j'ajoute des contraintes de validation
    // public static function loadValidatorMetadata(ClassMetadata $metadata): void
    // {
    //     $metadata->addPropertyConstraint('email', new Assert\Email([
    //         'message' => '"{{ value }}" Format mail invalide.',
    //     ]));
    // }
}