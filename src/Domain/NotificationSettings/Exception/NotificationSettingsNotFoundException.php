<?php

namespace App\Domain\NotificationSettings\Exception;

use App\Domain\Exception\EntityNotFoundException;

class NotificationSettingsNotFoundException extends EntityNotFoundException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
