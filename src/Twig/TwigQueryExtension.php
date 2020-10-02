<?php

namespace App\Twig;

use App\Entity\Bidding;
use App\Entity\OfferBidding;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigQueryExtension extends AbstractExtension
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function getFunctions()
    {
        return [
            new TwigFunction('findLastPrice', [$this, 'find']),
        ];
    }

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Bidding $bidding
     * @return Bidding[]
     */
    public function find(Bidding $bidding){
        $em = $this->em->getRepository(OfferBidding::class);
        return $em->findLastOffer($bidding);
    }

}