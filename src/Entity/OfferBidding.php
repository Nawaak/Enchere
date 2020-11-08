<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OfferBiddingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OfferBiddingRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *     "post"={
            "controller"=App\Controller\Api\OfferCreateController::class,
 *          "security"="is_granted('ROLE_USER')",
 *          "security_message"="Vous devez être authentifié pour pouvoir enchérir"
 *     },
 * },
 *     normalizationContext={"groups"={"create:offer"}},
 *     itemOperations={"get"},
 * )
 */
class OfferBidding
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("create:offer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @Groups("create:offer")
     */
    private float $price;

    /**
     * @ORM\ManyToOne(targetEntity=Bidding::class, inversedBy="offerBiddings")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Bidding $bidding;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offerBiddings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("create:offer")
     */
    private ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
