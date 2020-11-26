<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     * @param NotificationRepository $notificationRepository
     * @return Response
     */
    public function index(NotificationRepository $notificationRepository): Response
    {
        $notification = $notificationRepository->findBy(['user' => $this->getUser()]);
        return $this->render('notification/index.html.twig', compact('notification'));
    }
}
