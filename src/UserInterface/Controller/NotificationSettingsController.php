<?php

namespace App\UserInterface\Controller;

use App\Application\Contract\NotificationsModuleInterface;
use App\Application\UpdateNotificationSettings\UpdateNotificationSettingsCommand;
use App\UserInterface\Request\UpdateNotificationSettingsRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final readonly class NotificationSettingsController
{
    public function __construct(
        private NotificationsModuleInterface $notificationsModule,
    ) {
    }

    #[Route('/merchants/{merchantId}/notification-settings', methods: ['PATCH'])]
    public function updateNotificationSettings(UpdateNotificationSettingsRequest $request, Uuid $merchantId): JsonResponse
    {
        $this->notificationsModule->executeCommand(new UpdateNotificationSettingsCommand(
            $merchantId,
            $request->paymentSuccessUrl,
            $request->paymentFailureUrl
        ));

        return new JsonResponse(status: Response::HTTP_ACCEPTED);
    }
}
