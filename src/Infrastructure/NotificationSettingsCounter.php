<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\NotificationSettings\MerchantId;
use App\Domain\NotificationSettings\NotificationSettingsCounterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final readonly class NotificationSettingsCounter implements NotificationSettingsCounterInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countByMerchantId(MerchantId $merchantId): int
    {
        $query = $this->entityManager->createQuery('SELECT count(n) FROM App\Domain\NotificationSettings\NotificationSettings n WHERE n.merchantId = :merchantId')
            ->setParameter('merchantId', $merchantId);

        return (int) ($query->getSingleScalarResult());
    }
}
