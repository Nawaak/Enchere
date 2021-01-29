<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     * @param NotificationRepository $notificationRepository
     * @return Response
     */
    public function index(NotificationRepository $notificationRepository): Response
    {
        $notification = $notificationRepository->findBy(['user' => $this->getUser()], ['createdAt' => 'DESC']);
        return $this->render('notification/index.html.twig', compact('notification'));
    }

    /**
     * @Route("api/notifications/user/{id}/read", name="notification_read", methods={"POST"})
     * @param int $id
     * @return RedirectResponse
     */
    public function markRead(int $id): RedirectResponse
    {
        if($this->getUser()->getId() != $id){
            throw new ForbiddenOverwriteException('Forbidden',RESPONSE::HTTP_FORBIDDEN);
        }
        return $this->redirectToRoute('index');
    }
}
