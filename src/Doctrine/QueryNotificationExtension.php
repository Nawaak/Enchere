<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Notification;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

/**
 * Class qui permet de filter requete sur Collection || item (QueryItemExtensionInterface) envoyer par l'API
 */
final class QueryNotificationExtension implements QueryCollectionExtensionInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * Ajout d'une condition qui filtre les notifications renvoyer par ApiPlatform
     *
     * @param QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (Notification::class !== $resourceClass || null === $user = $this->security->getUser()) {
            return;
        }

        $lastNotificationReadAt = $user->getNotificationReadAt() ? $user->getNotificationReadAt()->format('Y-m-d H:i:s') : null;
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
        $queryBuilder->andWhere(sprintf('%s.createdAt > :last_read', $rootAlias));
        $queryBuilder->orderBy(sprintf('%s.createdAt',$rootAlias), 'ASC');
        $queryBuilder->setParameter('current_user', $user);
        $queryBuilder->setParameter('last_read', $lastNotificationReadAt);
    }
}