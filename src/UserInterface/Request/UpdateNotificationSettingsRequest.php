<?php

declare(strict_types=1);

namespace App\UserInterface\Request;

use Neuron\BuildingBlocks\UserInterface\Request\RequestInterface;

readonly class UpdateNotificationSettingsRequest implements RequestInterface
{
    public function __construct(
        public ?string $paymentSuccessUrl = null,
        public ?string $paymentFailureUrl = null,
    ) {
    }
}
