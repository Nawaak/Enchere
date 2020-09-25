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

    public function findOfferByBidding($bidding)
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.bidding = :bidding')
            ->setParameter('bidding', $bidding)
            ->orderBy('u.price', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return OfferBidding[] Returns an array of OfferBidding objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfferBidding
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
