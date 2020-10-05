<?php

namespace App\Entity;

use App\Repository\BiddingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BiddingRepository::class)
 */
class Bidding
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $image;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="biddings")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Category $category;

    /**
     * @ORM\Column(type="datetime",nullable=false)
     */
    private \DateTimeInterface $expireAt;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private float $startPrice = 5.99;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private bool $expire = false;

    /**
     * @ORM\OneToMany(targetEntity=OfferBidding::class, mappedBy="bidding")
     * @var Collection<int, OfferBidding>
     */
    private $offerBiddings;

    public function __construct()
    {
        $this->offerBiddings = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        /** @var Category $category */
        $this->category = $category;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getStartPrice(): ?float
    {
        return $this->startPrice;
    }

    public function setStartPrice(float $startPrice): self
    {
        $this->startPrice = $startPrice;

        return $this;
    }

    public function getExpire(): ?bool
    {
        return $this->expire;
    }

    public function setExpire(bool $expire): self
    {
        $this->expire = $expire;

        return $this;
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
            $offerBidding->setBidding($this);
        }

        return $this;
    }

    public function removeOfferBidding(OfferBidding $offerBidding): self
    {
        if ($this->offerBiddings->contains($offerBidding)) {
            $this->offerBiddings->removeElement($offerBidding);
            // set the owning side to null (unless already changed)
            if ($offerBidding->getBidding() === $this) {
                $offerBidding->setBidding(null);
            }
        }

        return $this;
    }
}
