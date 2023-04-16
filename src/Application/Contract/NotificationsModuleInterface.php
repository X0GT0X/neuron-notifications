<?php

declare(strict_types=1);

namespace App\Application\Contract;

interface NotificationsModuleInterface
{
    public function executeCQuery(QueryInterface $query): mixed;

    public function executeCommand(CommandInterface $command): mixed;
}
