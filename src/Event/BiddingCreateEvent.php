<?php

namespace App\Event;

use App\Entity\Bidding;
use Symfony\Contracts\EventDispatcher\Event;

class BiddingCreateEvent extends Event
{
    private Bidding $bidding;

    public function __construct(Bidding $bidding)
    {
        $this->bidding = $bidding;
    }

    public function getBidding(): Bidding
    {
        return $this->bidding;
    }
}