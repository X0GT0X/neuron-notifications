<?php

declare(strict_types=1);

namespace App\Infrastructure\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230424070932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update notification settings constraints.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE notification_settings ALTER payment_success_url DROP NOT NULL');
        $this->addSql('ALTER TABLE notification_settings ALTER payment_failure_url DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE notification_settings ALTER payment_success_url SET NOT NULL');
        $this->addSql('ALTER TABLE notification_settings ALTER payment_failure_url SET NOT NULL');
    }
}
