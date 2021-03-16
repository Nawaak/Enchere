<?php

namespace App\Controller;

use App\Entity\Bidding;
use App\Repository\BiddingRepository;
use App\Repository\OfferBiddingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BiddingController extends AbstractController
{

    /**
     * @Route("/offre/creer-une-offre", name="bidding_create")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function create(): Response
    {
        return $this->render('bidding/new.html.twig');
    }

    /**
     * @Route("/offre/{bidding}", name="bidding_show")
     * @param Bidding $bidding
     * @param BiddingRepository $repo
     * @param OfferBiddingRepository $offerBiddingRepo
     * @return Response
     */
    public function show(Bidding $bidding, BiddingRepository $repo, OfferBiddingRepository $offerBiddingRepo): Response
    {
        $bidding = $repo->findOneBy([
            'id' => $bidding->getId()
        ]);

        $offer = $offerBiddingRepo->findOfferByBidding($bidding);
        $lastOffer = $offerBiddingRepo->findLastOffer($bidding);

        return $this->render('bidding/show.html.twig',compact('bidding','offer','lastOffer'));
    }

}
