<?php

namespace App\Controller\Api;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 * @Route(path="/api/notification", name="api_notification_")
 */
class NotificationController extends AbstractController{


    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/user/{id}/read", name="read", methods={"POST"})
     * @param int $id
     * @param NotificationRepository $notificationRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function setReadNotification(int $id, NotificationRepository $notificationRepository, UserRepository $userRepository): JsonResponse{
        $user = $userRepository->findOneBy(["id" => $id]);
        $unread = $notificationRepository->findUnreadForUser($user);
        foreach ($unread as $k => $u){
            /** @var Notification $u */
            $u->setRead(true);
            $this->em->flush();
        }
        return new JsonResponse();
    }

}