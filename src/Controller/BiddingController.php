<?php

namespace App\Controller;

use App\Entity\Bidding;
use App\Entity\OfferBidding;
use App\Repository\BiddingRepository;
use App\Repository\OfferBiddingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BiddingController extends AbstractController
{
    /**
     * @Route("/offre/{bidding}", name="bidding_show")
     * @param Bidding $bidding
     * @param BiddingRepository $repo
     * @return Response
     */
    public function show(Bidding $bidding, BiddingRepository $repo, OfferBiddingRepository $offerBiddingRepo): Response
    {
        $bidding = $repo->findOneBy([
            'id' => $bidding->getId()
        ]);
        //$offer = $repo->findOfferByBidding($bidding->getId());
        $offer = $offerBiddingRepo->findOfferByBidding($bidding->getId());

        return $this->render('bidding/show.html.twig',compact('bidding','offer'));
    }
}
