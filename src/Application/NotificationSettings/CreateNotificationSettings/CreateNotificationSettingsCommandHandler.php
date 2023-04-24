<?php

declare(strict_types=1);

namespace App\Application\NotificationSettings\CreateNotificationSettings;

use App\Application\Configuration\Command\CommandHandlerInterface;
use App\Domain\NotificationSettings\MerchantId;
use App\Domain\NotificationSettings\NotificationSettings;
use App\Domain\NotificationSettings\NotificationSettingsCounterInterface;
use App\Domain\NotificationSettings\NotificationSettingsRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateNotificationSettingsCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private NotificationSettingsCounterInterface $notificationSettingsCounter,
        private NotificationSettingsRepositoryInterface $notificationSettingsRepository,
    ) {
    }

    public function __invoke(CreateNotificationSettingsCommand $command): void
    {
        $notificationSettings = NotificationSettings::createNew(new MerchantId((string) $command->merchantId), $this->notificationSettingsCounter);

        $this->notificationSettingsRepository->add($notificationSettings);
    }
}
