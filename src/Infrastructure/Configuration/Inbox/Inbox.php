<?php

namespace App\Infrastructure\Configuration\Inbox;

use Symfony\Component\Messenger\MessageBusInterface;

final readonly class Inbox implements InboxInterface
{
    public function __construct(
        private MessageBusInterface $inboxBus,
    ) {
    }

    public function add(InboxMessage $message): void
    {
        $this->inboxBus->dispatch($message);
    }
}
