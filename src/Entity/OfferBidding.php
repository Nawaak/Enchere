<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OfferBiddingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OfferBiddingRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *           "post"={
 *              "method"="POST",
 *              "controller"=App\Controller\Api\OfferCreateController::class,
 *              "route_name"="offer_bidding_post_publication",
 *              "security"="is_granted('ROLE_USER')",
 *              "security_message"="Vous devez être authentifié pour pouvoir enchérir",
 *         },
 *     },
 *     itemOperations={"get"},
 *     denormalizationContext={"groups"={"create:offer"}},
 *     normalizationContext={"groups"={"read:offer"}}
 * )
 */
class OfferBidding
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups("create:offer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="float")
     * @Groups({"create:offer","read:offer"})
     * @Assert\NotBlank()
     */
    private float $price;

    /**
     * @ORM\ManyToOne(targetEntity=Bidding::class, inversedBy="offerBiddings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"create:offer","read:offer"})
     */
    private ?Bidding $bidding;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offerBiddings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("read:offer")
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
