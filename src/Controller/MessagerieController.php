<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class MessagerieController extends AbstractController
{
    /**
     * @Route("/profil/messagerie", name="messagerie")
     */
    public function index()
    {
        return $this->render('messagerie/index.html.twig');
    }
}
