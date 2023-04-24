<?php

namespace App\Domain\NotificationSettings\Event;

use App\Domain\NotificationSettings\MerchantId;
use App\Domain\NotificationSettings\NotificationSettingsId;
use Neuron\BuildingBlocks\Domain\DomainEventBase;
use Neuron\BuildingBlocks\Domain\DomainEventInterface;
use Symfony\Component\Uid\Uuid;

class NotificationSettingsCreatedDomainEvent extends DomainEventBase
{
    public function __construct(
        public readonly NotificationSettingsId $notificationSettingsId,
        public readonly MerchantId $merchantId,
        ?Uuid $id = null,
        ?\DateTimeImmutable $occurredOn = null
    ) {
        parent::__construct($id, $occurredOn);
    }

    public static function from(Uuid $id, \DateTimeImmutable $occurredOn, array $data): DomainEventInterface
    {
        return new self(
            $data['notificationSettingsId']['value'],
            $data['merchantId']['value'],
            $id,
            $occurredOn
        );
    }
}
