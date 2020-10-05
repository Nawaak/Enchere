<?php

namespace App\Repository;

use App\Entity\Bidding;
use App\Entity\OfferBidding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bidding|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bidding|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bidding[]    findAll()
 * @method Bidding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiddingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bidding::class);
    }

    public function findOfferByBidding(?Bidding $bidding): ?array
    {
        return $this->createQueryBuilder('u')
            ->innerJoin(OfferBidding::class, 'o')
            ->where('o.bidding = :bidding')
            ->setParameter('bidding', $bidding)
            ->orderBy('u.price', 'desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int|null $id
     * @return array|null
     */
    public function findBiddingsWithCategory(?int $id)
    {
        return $this->createQueryBuilder('t')
            ->join(OfferBidding::class,'o')
            ->orderBy('o.price','desc')
            ->where('t.category = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();

    }
}
