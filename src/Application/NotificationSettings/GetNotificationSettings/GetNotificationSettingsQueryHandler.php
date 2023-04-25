<?php

declare(strict_types=1);

namespace App\Application\NotificationSettings\GetNotificationSettings;

use App\Application\Configuration\Connection\ConnectionInterface;
use App\Application\Configuration\Connection\DTOTransformingException;
use App\Application\Configuration\Connection\NotFoundException;
use App\Domain\NotificationSettings\Exception\NotificationSettingsNotFoundException;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetNotificationSettingsQueryHandler
{
    public function __construct(
        private ConnectionInterface $connection
    ) {
    }

    /**
     * @throws DTOTransformingException
     * @throws Exception
     * @throws NotificationSettingsNotFoundException
     */
    public function __invoke(GetNotificationSettingsQuery $query): NotificationSettingsDTO
    {
        try {
            $sql = '
            SELECT payment_success_url, payment_failure_url
            FROM notification_settings n
            WHERE n.merchant_id = :id
        ';

            return $this->connection->fetchOne($sql, NotificationSettingsDTO::class, ['id' => $query->merchantId]);
        } catch (NotFoundException) {
            throw new NotificationSettingsNotFoundException(\sprintf('Notification settings for merchant with id \'%s\' not found', $query->merchantId));
        }
    }
}
