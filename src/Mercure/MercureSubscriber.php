<?php

namespace App\Mercure;

use App\Entity\Notification;
use App\Entity\User;
use App\Event\OfferCreateEvent;
use App\Repository\OfferBiddingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class MercureSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;
    private PublisherInterface $publisher;
    private OfferBiddingRepository $offerBiddingRepository;
    private Security $security;
    private EventDispatcherInterface $dispatcher;
    private EntityManagerInterface $em;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        SerializerInterface $serializer,
        PublisherInterface $publisher,
        OfferBiddingRepository $offerBiddingRepository,
        Security $security,
        EventDispatcherInterface $dispatcher,
        EntityManagerInterface $em,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->serializer = $serializer;
        $this->publisher = $publisher;
        $this->offerBiddingRepository = $offerBiddingRepository;
        $this->security = $security;
        $this->dispatcher = $dispatcher;
        $this->em = $em;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            OfferCreateEvent::class => ['onOfferCreate'],
        ];
    }

    /**
     * @param OfferCreateEvent $event
     */
    public function onOfferCreate(OfferCreateEvent $event): void{
        $offer = $event->getOfferBidding();
        /** @var User $user */
        $user = $this->security->getUser();
        $name = $event->getBidding()->getName();
        $link = $this->urlGenerator->generate('bidding_show', ['bidding' => $offer->getBidding()->getId()]);
        $users = $this->offerBiddingRepository->findOfferUserExcerptCurrentUser($event->getBidding(), $user);

        // Tableau qui contiendra les ID utilisateur
        $ids = [];
        // Tableau qui contiendra l'instance de l'utilisateur
        $u = [];
        // Boucle sur tous les utilisateurs qui ont participé a une annonce et push sur un tableau
        for ($i = 0; $i < count($users); $i++){
            array_push($ids, $users[$i]->getUser()->getId());
            array_push($u, $users[$i]->getUser());
        }
        // On boucle sur les id(User::class) ayant participé a une annonce et on publie sur mercure
        foreach (array_unique($ids) as $key => $value){
            $update = new Update("/notifications/user/$value", $this->serializer->serialize([
                'type' => 'notification',
                'data' => $offer
            ], 'json', [
                'iri' => false
            ]));

            $this->publisher->__invoke($update);
        }
        // On boucle sur les instances Utilisateurs et on enregistre les notifiacation en base
        foreach ($u as $k => $v){
            /** @var User $v */
            $notification = new Notification();
            $notification->setMessage("Une nouvelle offre a été faite sur l'offre:&nbsp;<a href='$link'>$name</a>")
                ->setCreatedAt(new \DateTime("now"))
                ->setUser($v);
            $this->em->persist($notification);
        }
        $this->em->flush();
    }
}