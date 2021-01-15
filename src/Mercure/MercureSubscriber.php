<?php

namespace App\Mercure;

use App\Entity\User;
use App\Event\OfferCreateEvent;
use App\Repository\NotificationRepository;
use App\Repository\OfferBiddingRepository;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mercure\PublisherInterface;
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
    private NotificationRepository $notificationRepository;
    /**
     * @var NotificationService
     */
    private NotificationService $notificationService;

    public function __construct(
        SerializerInterface $serializer,
        PublisherInterface $publisher,
        OfferBiddingRepository $offerBiddingRepository,
        Security $security,
        EventDispatcherInterface $dispatcher,
        EntityManagerInterface $em,
        UrlGeneratorInterface $urlGenerator,
        NotificationRepository $notificationRepository,
        NotificationService $notificationService
    )
    {
        $this->serializer = $serializer;
        $this->publisher = $publisher;
        $this->offerBiddingRepository = $offerBiddingRepository;
        $this->security = $security;
        $this->dispatcher = $dispatcher;
        $this->em = $em;
        $this->urlGenerator = $urlGenerator;
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OfferCreateEvent::class => ['onOfferCreate'],
        ];
    }

    public function onOfferCreate(OfferCreateEvent $event): void{
        /** @var User $user */
        $user = $this->security->getUser();
        $name = $event->getBidding()->getName();
        $users = $this->offerBiddingRepository->findOfferUserExcerptCurrentUser($event->getBidding(), $user);

        // On boucle sur les instances Utilisateurs on enregistre les notifiacation en base et on notifie les utilisateur
        foreach ($users as $v){
            $this->notificationService->notifyUser($v->getUser(), "Quelqu'un a surenchéri sur l'annonce <strong>{$name}</strong> à laquel vous avez participé");
        }
    }
}