<?php

declare(strict_types=1);

namespace App\Domain\NotificationSettings;

use App\Domain\NotificationSettings\Event\NotificationSettingsCreatedDomainEvent;
use App\Domain\NotificationSettings\Event\NotificationSettingsUpdatedDomainEvent;
use App\Domain\NotificationSettings\Rule\NotificationSettingsPerMerchantIdShouldBeUniqueRule;
use Neuron\BuildingBlocks\Domain\AggregateRootInterface;
use Neuron\BuildingBlocks\Domain\Entity;
use Symfony\Component\Uid\Uuid;

class NotificationSettings extends Entity implements AggregateRootInterface
{
    public NotificationSettingsId $id;

    private MerchantId $merchantId;

    private ?string $paymentSuccessUrl = null;

    private ?string $paymentFailureUrl = null;

    private \DateTimeImmutable $createdAt;

    private ?\DateTimeImmutable $updatedAt = null;

    private function __construct(MerchantId $merchantId, NotificationSettingsCounterInterface $notificationSettingsCounter)
    {
        $this->checkRule(new NotificationSettingsPerMerchantIdShouldBeUniqueRule($merchantId, $notificationSettingsCounter));

        $this->id = new NotificationSettingsId((string) Uuid::v4());
        $this->merchantId = $merchantId;
        $this->createdAt = new \DateTimeImmutable();

        $this->addDomainEvent(new NotificationSettingsCreatedDomainEvent($this->id, $this->merchantId));
    }

    public static function createNew(MerchantId $merchantId, NotificationSettingsCounterInterface $notificationSettingsCounter): self
    {
        return new self($merchantId, $notificationSettingsCounter);
    }

    public function update(?string $paymentSuccessUrl = null, ?string $paymentFailureUrl = null): void
    {
        $this->paymentSuccessUrl = $paymentSuccessUrl ?? $this->paymentSuccessUrl;
        $this->paymentFailureUrl = $paymentFailureUrl ?? $this->paymentFailureUrl;

        $this->updatedAt = new \DateTimeImmutable();

        $this->addDomainEvent(new NotificationSettingsUpdatedDomainEvent(
            $this->id,
            $this->merchantId,
            $this->paymentSuccessUrl,
            $this->paymentFailureUrl,
        ));
    }
}
