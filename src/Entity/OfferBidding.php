<?php

namespace App\Entity;

use App\Repository\OfferBiddingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferBiddingRepository::class)
 */
class OfferBidding
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Bidding::class, inversedBy="offerBiddings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $bidding;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBidding(): ?Bidding
    {
        return $this->bidding;
    }

    public function setBidding(?Bidding $bidding): self
    {
        $this->bidding = $bidding;

        return $this;
    }
}
