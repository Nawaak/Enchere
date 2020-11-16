<?php

namespace App\Event;

use App\Entity\Bidding;
use App\Entity\OfferBidding;
use Symfony\Contracts\EventDispatcher\Event;

class OfferCreateEvent extends Event {

    private OfferBidding $offerBidding;

    public function __construct(OfferBidding $offerBidding)
    {
        $this->offerBidding = $offerBidding;
    }

    public function getOfferBidding(): OfferBidding
    {
        return $this->offerBidding;
    }

    public function getBidding(): ?Bidding
    {
        return $this->offerBidding->getBidding();
    }

}