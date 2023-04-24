<?php

namespace App\Infrastructure\Repository;

use App\Domain\NotificationSettings\Exception\NotificationSettingsNotFoundException;
use App\Domain\NotificationSettings\MerchantId;
use App\Domain\NotificationSettings\NotificationSettings;
use App\Domain\NotificationSettings\NotificationSettingsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class NotificationSettingsRepository extends ServiceEntityRepository implements NotificationSettingsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationSettings::class);
    }

    public function add(NotificationSettings $notificationSettings): void
    {
        $this->getEntityManager()->persist($notificationSettings);
    }

    public function getByMerchantId(MerchantId $merchantId): NotificationSettings
    {
        /** @var ?NotificationSettings $notificationSettings */
        $notificationSettings = $this->findOneBy(['merchantId' => $merchantId]);

        return $notificationSettings ?? throw new NotificationSettingsNotFoundException(\sprintf('Notification settings for merchant with id \'%s\' not found', $merchantId->getValue()));
    }
}
