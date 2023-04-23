<?php

declare(strict_types=1);

namespace App\Application\CreateNotificationSettings;

use App\IntegrationEvent\MerchantCreatedIntegrationEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'sync')]
class MerchantCreatedIntegrationEventHandler
{
    public function __invoke(MerchantCreatedIntegrationEvent $event): void
    {
        dd($event);
    }
}
