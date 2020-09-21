<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id ;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Bidding::class, mappedBy="category", orphanRemoval=true)
     */
    private $biddings;

    public function __construct()
    {
        $this->biddings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Génére automatiquement le Slug a chaque persistence / update
     *
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function autoSlugName(): string
    {
        $slug = new Slugify();
        $this->slug = $slug->slugify((string)$this->getName());
        return $this->slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Bidding[]
     */
    public function getBiddings(): Collection
    {
        return $this->biddings;
    }

    public function addBidding(Bidding $bidding): self
    {
        if (!$this->biddings->contains($bidding)) {
            $this->biddings[] = $bidding;
            $bidding->setCategory($this);
        }

        return $this;
    }

    public function removeBidding(Bidding $bidding): self
    {
        if ($this->biddings->contains($bidding)) {
            $this->biddings->removeElement($bidding);
            // set the owning side to null (unless already changed)
            if ($bidding->getCategory() === $this) {
                $bidding->setCategory(null);
            }
        }

        return $this;
    }
}