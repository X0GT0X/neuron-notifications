<?php

declare(strict_types=1);

namespace App\Tests\IntegrationTest\NotificationSettings;

use App\Application\NotificationSettings\CreateNotificationSettings\CreateNotificationSettingsCommand;
use App\Application\NotificationSettings\GetNotificationSettings\GetNotificationSettingsQuery;
use App\Application\NotificationSettings\GetNotificationSettings\NotificationSettingsDTO;
use App\Application\NotificationSettings\UpdateNotificationSettings\UpdateNotificationSettingsCommand;
use App\Domain\NotificationSettings\Exception\NotificationSettingsNotFoundException;
use App\Tests\IntegrationTest\IntegrationTestCase;
use Symfony\Component\Uid\Uuid;

class UpdateNotificationSettingsTest extends IntegrationTestCase
{
    public function testUpdateIntegrationSettingsCommand(): void
    {
        $merchantId = Uuid::fromString('ec6e6c27-06f7-4741-a4ff-137d1d02ed9c');

        $this->notificationsModule->executeCommand(new CreateNotificationSettingsCommand($merchantId));
        $this->notificationsModule->executeCommand(new UpdateNotificationSettingsCommand(
            $merchantId,
            'https://merchant.com/payment-success',
            'https://merchant.com/payment-failure'
        ));

        /** @var NotificationSettingsDTO $notificationSettings */
        $notificationSettings = $this->notificationsModule->executeQuery(new GetNotificationSettingsQuery($merchantId));

        $this->assertEquals('https://merchant.com/payment-success', $notificationSettings->paymentSuccessUrl);
        $this->assertEquals('https://merchant.com/payment-failure', $notificationSettings->paymentFailureUrl);
    }

    public function testThatThrowsNotFoundExceptionIfNotificationSettingsForMerchantIdNotFound(): void
    {
        $merchantId = Uuid::fromString('ec6e6c27-06f7-4741-a4ff-137d1d02ed9c');

        $this->expectException(NotificationSettingsNotFoundException::class);
        $this->expectExceptionMessage(\sprintf('Notification settings for merchant with id \'%s\' not found', $merchantId));

        $this->notificationsModule->executeCommand(new UpdateNotificationSettingsCommand(
            $merchantId,
            'https://merchant.com/payment-success',
            'https://merchant.com/payment-failure'
        ));
    }
}
