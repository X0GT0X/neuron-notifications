<?php

declare(strict_types=1);

namespace App\Tests\UnitTest\Domain\NotificationSettings;

use App\Domain\NotificationSettings\Event\NotificationSettingsCreatedDomainEvent;
use App\Domain\NotificationSettings\Event\NotificationSettingsUpdatedDomainEvent;
use App\Domain\NotificationSettings\MerchantId;
use App\Domain\NotificationSettings\NotificationSettings;
use App\Domain\NotificationSettings\NotificationSettingsCounterInterface;
use App\Domain\NotificationSettings\Rule\NotificationSettingsPerMerchantIdShouldBeUniqueRule;
use App\Tests\UnitTest\UnitTestCase;

class NotificationSettingsTest extends UnitTestCase
{
    public function testThatSuccessfullyCreatesNewNotificationSettings(): void
    {
        $merchantId = new MerchantId('7f63d7a0-29c8-43c5-b618-83a9a343130a');
        $notificationSettingsCounter = $this->createMock(NotificationSettingsCounterInterface::class);
        $notificationSettingsCounter->expects($this->once())
            ->method('countByMerchantId')
            ->with($merchantId)
            ->willReturn(0);

        $notificationSettings = NotificationSettings::createNew($merchantId, $notificationSettingsCounter);

        /** @var NotificationSettingsCreatedDomainEvent $domainEvent */
        $domainEvent = $this->assertPublishedDomainEvents($notificationSettings, NotificationSettingsCreatedDomainEvent::class)[0];

        $this->assertEquals($merchantId, $domainEvent->merchantId);
        $this->assertEquals($notificationSettings->id, $domainEvent->notificationSettingsId);
    }

    public function testThatCreatingNewNotificationSettingsForMerchantIdThatHaveNotificationSettingsBreaksNotificationSettingsPerMerchantIdShouldBeUniqueRule(): void
    {
        $merchantId = new MerchantId('7f63d7a0-29c8-43c5-b618-83a9a343130a');
        $notificationSettingsCounter = $this->createMock(NotificationSettingsCounterInterface::class);
        $notificationSettingsCounter->expects($this->once())
            ->method('countByMerchantId')
            ->with($merchantId)
            ->willReturn(1);

        $this->expectBrokenRule(
            NotificationSettingsPerMerchantIdShouldBeUniqueRule::class,
            \sprintf('Notification settings for merchant with id \'%s\' already exist', $merchantId->getValue()),
            static fn () => NotificationSettings::createNew($merchantId, $notificationSettingsCounter)
        );
    }

    public function testThatSuccessfullyUpdatesNotificationSettings(): void
    {
        $merchantId = new MerchantId('7f63d7a0-29c8-43c5-b618-83a9a343130a');
        $notificationSettingsCounter = $this->createStub(NotificationSettingsCounterInterface::class);

        $notificationSettings = NotificationSettings::createNew($merchantId, $notificationSettingsCounter);

        $notificationSettings->update(
            'https://merchant.com/payment-success',
            'https://merchant.com/payment-failure'
        );

        /** @var NotificationSettingsUpdatedDomainEvent $domainEvent */
        $domainEvent = $this->assertPublishedDomainEvents($notificationSettings, NotificationSettingsUpdatedDomainEvent::class)[0];
        $this->assertEquals($notificationSettings->id, $domainEvent->notificationSettingsId);
        $this->assertEquals($merchantId, $domainEvent->merchantId);
        $this->assertEquals('https://merchant.com/payment-success', $domainEvent->paymentSuccessUrl);
        $this->assertEquals('https://merchant.com/payment-failure', $domainEvent->paymentFailureUrl);
    }
}
