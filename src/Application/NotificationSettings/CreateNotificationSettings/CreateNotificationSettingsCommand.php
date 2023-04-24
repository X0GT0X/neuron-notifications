<?php

declare(strict_types=1);

namespace App\Application\NotificationSettings\CreateNotificationSettings;

use App\Application\Contract\AbstractCommand;
use Symfony\Component\Uid\Uuid;

class CreateNotificationSettingsCommand extends AbstractCommand
{
    public function __construct(
        public readonly Uuid $merchantId,
    ) {
        parent::__construct();
    }
}
