<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

class NotificationService{

    private EntityManagerInterface $em;
    private PublisherInterface $publisher;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em, PublisherInterface $publisher, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->publisher = $publisher;
        $this->serializer = $serializer;
    }

    public function notifyUser(User $user, string $message): void{

        $notification = new Notification();
        $notification->setMessage($message)
            ->setCreatedAt(new \DateTime())
            ->setUser($user);
        $this->em->persist($notification);
        $this->em->flush();

        $update = new Update("/notifications/user/{$user->getId()}", $this->serializer->serialize([
            'type' => 'notification',
            'data' => $notification
        ], 'json', [
            'iri' => false
        ]));
        $this->publisher->__invoke($update);
    }

}