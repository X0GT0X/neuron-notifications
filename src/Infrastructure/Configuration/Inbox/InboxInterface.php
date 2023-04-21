<?php

namespace App\Infrastructure\Configuration\Inbox;

interface InboxInterface
{
    public function add(InboxMessage $message): void;
}
