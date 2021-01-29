<?php

namespace App\Controller\Api;

use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 * @Route(path="/api/notification/", name="api_notification_")
 * @IsGranted("ROLE_USER")
 */
class NotificationController extends AbstractController{


    private EntityManagerInterface $em;
    private NotificationRepository $notificationRepository;

    public function __construct(EntityManagerInterface $em, NotificationRepository $notificationRepository)
    {
        $this->em = $em;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @Route("read", name="read", methods={"POST"})
     */
    public function setNotificationRead(): JsonResponse
    {
        $user = $this->getUser();
        $user->setNotificationReadAt(new \DateTime());
        $this->em->flush();
        return new JsonResponse();
    }

}