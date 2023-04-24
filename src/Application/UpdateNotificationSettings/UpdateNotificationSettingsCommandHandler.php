<?php

namespace App\Application\UpdateNotificationSettings;

use App\Application\Configuration\Command\CommandHandlerInterface;
use App\Domain\NotificationSettings\Exception\NotificationSettingsNotFoundException;
use App\Domain\NotificationSettings\MerchantId;
use App\Domain\NotificationSettings\NotificationSettingsRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateNotificationSettingsCommandHandler implements CommandHandlerInterface
{
    public function __construct(private NotificationSettingsRepositoryInterface $notificationSettingsRepository)
    {
    }

    /**
     * @throws NotificationSettingsNotFoundException
     */
    public function __invoke(UpdateNotificationSettingsCommand $command): void
    {
        $notificationSettings = $this->notificationSettingsRepository->getByMerchantId(new MerchantId($command->merchantId));

        $notificationSettings->update($command->paymentSuccessUrl, $command->paymentFailureUrl);
    }
}
