<?php

declare(strict_types=1);

namespace App\Domain\NotificationSettings;

use App\Domain\NotificationSettings\Exception\NotificationSettingsNotFoundException;

interface NotificationSettingsRepositoryInterface
{
    public function add(NotificationSettings $notificationSettings): void;

    /**
     * @throws NotificationSettingsNotFoundException
     */
    public function getByMerchantId(MerchantId $merchantId): NotificationSettings;
}
