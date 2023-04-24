<?php

namespace App\Domain\NotificationSettings\Rule;

use App\Domain\NotificationSettings\MerchantId;
use App\Domain\NotificationSettings\NotificationSettingsCounterInterface;
use Neuron\BuildingBlocks\Domain\AbstractBusinessRule;

class NotificationSettingsPerMerchantIdShouldBeUniqueRule extends AbstractBusinessRule
{
    public function __construct(
        private readonly MerchantId $merchantId,
        private readonly NotificationSettingsCounterInterface $notificationSettingsCounter
    ) {
    }

    public function isBroken(): bool
    {
        return $this->notificationSettingsCounter->countByMerchantId($this->merchantId) > 0;
    }

    public function getMessageTemplate(): string
    {
        return 'Notification settings for merchant with id \'%s\' already exist';
    }

    public function getMessageArguments(): array
    {
        return [$this->merchantId->getValue()];
    }
}
