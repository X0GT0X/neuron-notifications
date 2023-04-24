<?php

namespace App\Application\UpdateNotificationSettings;

use App\Application\Contract\AbstractCommand;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateNotificationSettingsCommand extends AbstractCommand
{
    public function __construct(
        public readonly Uuid $merchantId,
        #[Assert\Url]
        public readonly ?string $paymentSuccessUrl,
        #[Assert\Url]
        public readonly ?string $paymentFailureUrl,
    ) {
        parent::__construct();
    }
}
