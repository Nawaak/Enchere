<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=OfferBidding::class, mappedBy="user")
     * @var Collection<int, OfferBidding>
     */
    private $offerBiddings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("create:offer")
     */
    private string $username;

    public function __construct()
    {
        $this->offerBiddings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|OfferBidding[]
     */
    public function getOfferBiddings(): Collection
    {
        return $this->offerBiddings;
    }

    public function addOfferBidding(OfferBidding $offerBidding): self
    {
        if (!$this->offerBiddings->contains($offerBidding)) {
            $this->offerBiddings[] = $offerBidding;
            $offerBidding->setUser($this);
        }

        return $this;
    }

    public function removeOfferBidding(OfferBidding $offerBidding): self
    {
        if ($this->offerBiddings->contains($offerBidding)) {
            $this->offerBiddings->removeElement($offerBidding);
            // set the owning side to null (unless already changed)
            if ($offerBidding->getUser() === $this) {
                $offerBidding->setUser(null);
            }
        }

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
