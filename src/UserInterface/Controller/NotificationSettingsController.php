<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\Application\Contract\NotificationsModuleInterface;
use App\Application\NotificationSettings\GetNotificationSettings\GetNotificationSettingsQuery;
use App\Application\NotificationSettings\UpdateNotificationSettings\UpdateNotificationSettingsCommand;
use App\UserInterface\Request\UpdateNotificationSettingsRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

final readonly class NotificationSettingsController
{
    public function __construct(
        private NotificationsModuleInterface $notificationsModule,
        private SerializerInterface $serializer,
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

    #[Route('/merchants/{merchantId}/notification-settings', methods: ['GET'])]
    public function getNotificationSettings(Uuid $merchantId): JsonResponse
    {
        $notificationSettings = $this->notificationsModule->executeQuery(new GetNotificationSettingsQuery($merchantId));

        return new JsonResponse(
            $this->serializer->serialize($notificationSettings, 'json'),
            json: true
        );
    }
}
