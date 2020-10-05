<?php

namespace App\Repository;

use App\Entity\Bidding;
use App\Entity\OfferBidding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfferBidding|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferBidding|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferBidding[]    findAll()
 * @method OfferBidding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class OfferBiddingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferBidding::class);
    }

    /**
     * @param Bidding|null $bidding
     * @return int|mixed|string
     */
    public function findOfferByBidding(?Bidding $bidding)
    {
        return $this->createQueryBuilder('u')
            ->join(OfferBidding::class,'o')
            ->where('u.bidding = :bidding')
            ->setParameter('bidding', $bidding)
            ->orderBy('u.price', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param Bidding|null $bidding
     * @return int|mixed|string
     */
    public function findLastOffer(?Bidding $bidding)
    {
        return $this->createQueryBuilder('u')
            ->where('u.bidding = :bidding')
            ->setParameter('bidding', $bidding)
            ->orderBy('u.price','DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }
}
