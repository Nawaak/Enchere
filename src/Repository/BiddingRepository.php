<?php

namespace App\Repository;

use App\Entity\Bidding;
use App\Entity\OfferBidding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Array_;

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
    

    public function findOfferByBidding($bidding)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin(OfferBidding::class,'o')
            ->where('o.bidding = :bidding')
            ->setParameter('bidding', $bidding)
            ->getQuery()
        ;
    }
    // /**
    //  * @return Bidding[] Returns an array of Bidding objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bidding
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param int|null $id
     * @return array|null
     */
    public function findBiddingsWithCategory(?int $id): ?array
    {
        return $this->createQueryBuilder('t')
            ->where('t.category = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();

    }
}
