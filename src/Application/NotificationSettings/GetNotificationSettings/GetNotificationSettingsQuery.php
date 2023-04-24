<?php

declare(strict_types=1);

namespace App\Application\NotificationSettings\GetNotificationSettings;

use App\Application\Contract\QueryInterface;
use Symfony\Component\Uid\Uuid;

readonly class GetNotificationSettingsQuery implements QueryInterface
{
    public function __construct(
        public Uuid $merchantId
    ) {
    }
}
