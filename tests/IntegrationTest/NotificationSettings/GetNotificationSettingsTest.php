<?php

declare(strict_types=1);

namespace App\Tests\IntegrationTest\NotificationSettings;

use App\Application\NotificationSettings\CreateNotificationSettings\CreateNotificationSettingsCommand;
use App\Application\NotificationSettings\GetNotificationSettings\GetNotificationSettingsQuery;
use App\Application\NotificationSettings\GetNotificationSettings\NotificationSettingsDTO;
use App\Domain\NotificationSettings\Exception\NotificationSettingsNotFoundException;
use App\Tests\IntegrationTest\IntegrationTestCase;
use Symfony\Component\Uid\Uuid;

class GetNotificationSettingsTest extends IntegrationTestCase
{
    public function testGetNotificationSettingsQuery(): void
    {
        $merchantId = Uuid::fromString('ec6e6c27-06f7-4741-a4ff-137d1d02ed9c');

        $this->notificationsModule->executeCommand(new CreateNotificationSettingsCommand($merchantId));

        $notificationSettings = $this->notificationsModule->executeCQuery(new GetNotificationSettingsQuery($merchantId));

        $this->assertInstanceOf(NotificationSettingsDTO::class, $notificationSettings);
        $this->assertNull($notificationSettings->paymentSuccessUrl);
        $this->assertNull($notificationSettings->paymentFailureUrl);
    }

    public function testThatThrowsNotFoundExceptionIfNotificationSettingsForMerchantIdNotFound(): void
    {
        $merchantId = Uuid::fromString('ec6e6c27-06f7-4741-a4ff-137d1d02ed9c');

        $this->expectException(NotificationSettingsNotFoundException::class);
        $this->expectExceptionMessage(\sprintf('Notification settings for merchant with id \'%s\' not found', $merchantId));

        $this->notificationsModule->executeCQuery(new GetNotificationSettingsQuery($merchantId));
    }
}
