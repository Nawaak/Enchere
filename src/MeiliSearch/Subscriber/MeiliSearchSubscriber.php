<?php

namespace App\MeiliSearch\Subscriber;

use App\Event\BiddingCreateEvent;
use App\Event\OfferCreateEvent;
use App\MeiliSearch\MeiliSearchIndexer;
use App\MeiliSearch\Normalizer\BiddingNormalizer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MeiliSearchSubscriber implements EventSubscriberInterface
{

    private MeiliSearchIndexer $meiliSearchIndexer;
    private BiddingNormalizer $biddingNormalizer;

    public function __construct(MeiliSearchIndexer $meiliSearchIndexer, BiddingNormalizer $biddingNormalizer)
    {
        $this->meiliSearchIndexer = $meiliSearchIndexer;
        $this->biddingNormalizer = $biddingNormalizer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BiddingCreateEvent::class => 'onBiddingCreated'
        ];
    }

    public function onOfferCreated(OfferCreateEvent $event){
        $content = $this->biddingNormalizer->normalize($event->getBidding());
        $this->meiliSearchIndexer->createOrUpdate('offer', [
            $content
        ]);
    }
}