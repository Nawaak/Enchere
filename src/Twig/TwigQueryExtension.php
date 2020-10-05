<?php

namespace App\Twig;

use App\Entity\Bidding;
use App\Repository\OfferBiddingRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigQueryExtension extends AbstractExtension
{


    /** @var OfferBiddingRepository */
    private OfferBiddingRepository $repository;

    public function getFunctions()
    {
        return [
            new TwigFunction('findLastPrice', [$this, 'find']),
        ];
    }

    public function __construct(OfferBiddingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Bidding $bidding
     * @return Bidding[]
     */
    public function find(Bidding $bidding): ?array{
        return $this->repository->findLastOffer($bidding);
    }

}