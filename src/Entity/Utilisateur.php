<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ApiResource]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NOM', fields: ['nom'])]
#[UniqueEntity(fields: ['nom'], message: 'There is already an account with this nom')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 180)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom_client = null;

    #[ORM\Column]
    private ?int $telephone_client = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_client = null;

    #[ORM\Column(length: 255)]
    private ?string $code_postal_client = null;

    #[ORM\Column(length: 255)]
    private ?string $ville_client = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coef_client = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    // #[ORM\Column(nullable: true)]
    #[ORM\Column]
    // private ?bool $is_verified = null;
    private ?bool $is_verified = false;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $verificationTokenCreatedAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    // #[ORM\Column(type: 'string', length: 100)]
    // private $resetToken;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $resetToken;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'Utilisateur')]
    private Collection $commandes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_livraison = null;

    /**
     * @var Collection<int, Favorite>
     */
    #[ORM\OneToMany(targetEntity: Favorite::class, mappedBy: 'Utilisateur')]
    private Collection $favorites;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->createdAt = new \DateTime(); // Initialise createdAt
        // Définit la date et l'heure actuelle par défaut

        $this->verificationTokenCreatedAt = new \DateTime();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVerificationTokenCreatedAt(): ?\DateTimeInterface
    {
    return $this->verificationTokenCreatedAt;
    }

    // Méthode pour vérifier si le token a expiré
    public function isVerificationTokenExpired(): bool
    {
        if (!$this->verificationTokenCreatedAt) {
            return true; // Si le token n'est pas créé, il est considéré comme expiré
        }
    $expirationDate = (clone $this->verificationTokenCreatedAt)->modify('+24 hours'); // durée d'expiration
    return new \DateTime() > $expirationDate;
    }

    // Getter pour createdAt
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->nom;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }


    public function getPrenomClient(): ?string
    {
        return $this->prenom_client;
    }

    public function setPrenomClient(string $prenom_client): static
    {
        $this->prenom_client = $prenom_client;

        return $this;
    }
    

    public function getTelephoneClient(): ?int
    {
        return $this->telephone_client;
    }

    public function setTelephoneClient(int $telephone_client): static
    {
        $this->telephone_client = $telephone_client;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresse_client;
    }

    public function setAdresseClient(string $adresse_client): static
    {
        $this->adresse_client = $adresse_client;

        return $this;
    }

    public function getCodePostalClient(): ?string
    {
        return $this->code_postal_client;
    }

    public function setCodePostalClient(string $code_postal_client): static
    {
        $this->code_postal_client = $code_postal_client;

        return $this;
    }

    public function getVilleClient(): ?string
    {
        return $this->ville_client;
    }

    public function setVilleClient(string $ville_client): static
    {
        $this->ville_client = $ville_client;

        return $this;
    }

    public function getCoefClient(): ?string
    {
        return $this->coef_client;
    }

    public function setCoefClient(string $coef_client): static
    {
        $this->coef_client = $coef_client;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setVerified(bool $is_verified): self
    {
        $this->is_verified = $is_verified;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }
    
    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;
    
        return $this;
    }
    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUtilisateur() === $this) {
                $commande->setUtilisateur(null);
            }
        }

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

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setUtilisateur($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUtilisateur() === $this) {
                $favorite->setUtilisateur(null);
            }
        }

        return $this;
    }

}
