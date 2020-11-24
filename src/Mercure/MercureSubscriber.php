<?php

namespace App\Mercure;

use App\Entity\OfferBidding;
use App\Entity\User;
use App\Event\OfferCreateEvent;
use App\Repository\BiddingRepository;
use App\Repository\OfferBiddingRepository;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MercureSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;
    private PublisherInterface $publisher;
    private OfferBiddingRepository $offerBiddingRepository;
    private Security $security;
    private UserInterface $user;

    public function __construct(
        SerializerInterface $serializer,
        PublisherInterface $publisher,
        OfferBiddingRepository $offerBiddingRepository,
        Security $security
    )
    {
        $this->serializer = $serializer;
        $this->publisher = $publisher;
        $this->offerBiddingRepository = $offerBiddingRepository;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            OfferCreateEvent::class => 'onOfferCreate',
        ];
    }

    public function onOfferCreate(OfferCreateEvent $event){
        $offer = $event->getOfferBidding();
        /** @var User $user */
        $user = $this->security->getUser();
        $users = $this->offerBiddingRepository->findOfferUserExcerptCurrentUser($event->getBidding(), $user);
        $arr = [];
        for ($i = 0; $i < count($users); $i++){
            array_push($arr, $users[$i]->getUser()->getId());
        }
        foreach (array_unique($arr) as $key => $value){
            $update = new Update("/notifications/user/$value", $this->serializer->serialize([
                'type' => 'notification',
                'data' => $offer
            ], 'json', [
                'iri' => false
            ]));
            $this->publisher->__invoke($update);
        }
    }
}