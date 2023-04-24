<?php

declare(strict_types=1);

namespace App\Application\NotificationSettings\CreateNotificationSettings;

use App\Application\Contract\NotificationsModuleInterface;
use App\IntegrationEvent\MerchantCreatedIntegrationEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'sync')]
final readonly class MerchantCreatedIntegrationEventHandler
{
    public function __construct(
        private NotificationsModuleInterface $notificationsModule
    ) {
    }

    public function __invoke(MerchantCreatedIntegrationEvent $event): void
    {
        $this->notificationsModule->executeCommand(new CreateNotificationSettingsCommand($event->merchantId));
    }
}
