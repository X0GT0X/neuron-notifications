<?php

declare(strict_types=1);

namespace App\IntegrationEvent;

use Neuron\BuildingBlocks\Integration\IntegrationEvent;
use Neuron\BuildingBlocks\Integration\ReceivedIntegrationEventInterface;
use Symfony\Component\Uid\Uuid;

class MerchantCreatedIntegrationEvent extends IntegrationEvent implements ReceivedIntegrationEventInterface
{
    public const EVENT_TYPE = 'MerchantCreated';

    public function __construct(
        Uuid $id,
        \DateTimeImmutable $occurredOn,
        public Uuid $merchantId,
    ) {
        parent::__construct($id, $occurredOn);
    }

    public static function from(Uuid $id, \DateTimeImmutable $occurredOn, array $data): IntegrationEvent
    {
        return new self($id, $occurredOn, Uuid::fromString($data['merchantId']));
    }

    public static function getEventType(): string
    {
        return self::EVENT_TYPE;
    }

    public function getData(): array
    {
        return [
            'merchantId' => $this->merchantId,
        ];
    }
}
