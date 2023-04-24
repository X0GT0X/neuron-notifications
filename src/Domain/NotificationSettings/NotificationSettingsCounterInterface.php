<?php

declare(strict_types=1);

namespace App\Domain\NotificationSettings;

interface NotificationSettingsCounterInterface
{
    public function countByMerchantId(MerchantId $merchantId): int;
}
