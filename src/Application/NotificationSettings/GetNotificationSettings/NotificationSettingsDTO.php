<?php

declare(strict_types=1);

namespace App\Application\NotificationSettings\GetNotificationSettings;

final readonly class NotificationSettingsDTO
{
    public function __construct(
        public ?string $paymentSuccessUrl,
        public ?string $paymentFailureUrl,
    ) {
    }
}
