<?php

declare(strict_types=1);

namespace App\Tests\IntegrationTest\NotificationSettings;

use App\Application\NotificationSettings\CreateNotificationSettings\CreateNotificationSettingsCommand;
use App\Application\NotificationSettings\GetNotificationSettings\GetNotificationSettingsQuery;
use App\Application\NotificationSettings\GetNotificationSettings\NotificationSettingsDTO;
use App\Tests\IntegrationTest\IntegrationTestCase;
use Symfony\Component\Uid\Uuid;

class CreateNotificationSettingsTest extends IntegrationTestCase
{
    public function testCreateNotificationSettingsCommand(): void
    {
        $merchantId = Uuid::fromString('ec6e6c27-06f7-4741-a4ff-137d1d02ed9c');

        $this->notificationsModule->executeCommand(new CreateNotificationSettingsCommand($merchantId));

        /** @var NotificationSettingsDTO $notificationSettings */
        $notificationSettings = $this->notificationsModule->executeQuery(new GetNotificationSettingsQuery($merchantId));

        $this->assertNull($notificationSettings->paymentSuccessUrl);
        $this->assertNull($notificationSettings->paymentFailureUrl);
    }
}
