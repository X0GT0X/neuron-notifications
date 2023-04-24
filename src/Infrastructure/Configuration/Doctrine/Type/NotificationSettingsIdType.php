<?php

declare(strict_types=1);

namespace App\Infrastructure\Configuration\Doctrine\Type;

use App\Domain\NotificationSettings\NotificationSettingsId;

class NotificationSettingsIdType extends AbstractIdType
{
    public const NAME = 'notification_settings_id';

    public static function getIdClass(): string
    {
        return NotificationSettingsId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
