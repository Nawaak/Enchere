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

    /**
     * @param int|null $id
     * @return array|null
     */
    public function findBiddingsWithCategory(?int $id)
    {
        $now = new \DateTime('now');
        return $this->createQueryBuilder('t')
            ->where('t.category = :id')
            ->setParameter('id',$id)
            ->andWhere("t.expireAt > :now")
            ->setParameter('now',$now)
            ->getQuery()
            ->getResult();
    }
}
