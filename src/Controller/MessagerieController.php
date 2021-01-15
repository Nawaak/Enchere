<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class MessagerieController extends AbstractController
{
    /**
     * @Route("/profil/messagerie", name="messagerie")
     */
    public function index(): Response
    {
        return $this->render('messagerie/index.html.twig');
    }
}
