<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @param User $user
     * @return int|mixed|string
     */
    public function findUnreadCountForUser(User $user)
    {
        return $this->createQueryBuilder('n')
            ->select('count(n.id)')
            ->where('n.user = :user')
            ->setParameter('user', $user)
            ->andWhere('n.read = 0')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param User|null $user
     * @return int|mixed|string
     */
    public function findUnreadForUser(?User $user)
    {
        return $this->createQueryBuilder('n')
            ->where('n.user = :user')
            ->setParameter('user', $user)
            ->andWhere('n.read = 0')
            ->getQuery()
            ->getResult();
    }
}
