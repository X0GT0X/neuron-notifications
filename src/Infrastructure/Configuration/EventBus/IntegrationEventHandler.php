<?php

namespace App\Infrastructure\Configuration\EventBus;

use App\Infrastructure\Configuration\Inbox\InboxInterface;
use App\Infrastructure\Configuration\Inbox\InboxMessage;
use Neuron\BuildingBlocks\Integration\IntegrationEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler(fromTransport: 'async')]
final readonly class IntegrationEventHandler
{
    public function __construct(private InboxInterface $inbox, private SerializerInterface $serializer)
    {
    }

    public function __invoke(IntegrationEvent $event): void
    {
        $this->inbox->add(new InboxMessage(
            $event->getId(),
            $event->getOccurredOn(),
            $this->serializer->serialize($event, 'json'),
        ));
    }
}
