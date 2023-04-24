<?php

namespace App\Application\CreateNotificationSettings;

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
