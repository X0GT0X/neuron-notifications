<?php

namespace App\Domain\NotificationSettings;

interface NotificationSettingsCounterInterface
{
    public function countByMerchantId(MerchantId $merchantId): int;
}
