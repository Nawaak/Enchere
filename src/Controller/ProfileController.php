<?php


namespace App\Controller;

use App\Repository\BiddingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{

    /**
     * @Route("/mon-compte", name="profile")
     * @param BiddingRepository $biddingRepository
     * @return Response
     */
    public function index(BiddingRepository $biddingRepository): Response
    {
        $bidding = $biddingRepository->findBy(['user' => $this->getUser()->getId()], ['expireAt' => 'ASC']);
        return $this->render('profile/index.html.twig', compact('bidding'));
    }

}