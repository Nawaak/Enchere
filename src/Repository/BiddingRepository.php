<?php

namespace App\Repository;

use App\Entity\Bidding;
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
    public function findBiddingsWithCategory(?int $id)
    {
        return $this->createQueryBuilder('t')
            ->where('t.category = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();

    }
}
