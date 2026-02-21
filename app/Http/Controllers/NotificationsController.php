<?php

namespace App\Http\Controllers;
use App\Services\NotificationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends CrudController
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $service)
    {
        parent::__construct($service);
        $this->notificationService = $service;
    }


    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->notificationService->store($request->all());
            return response()->json(['message' => 'Notification created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create notification', 'error' => $e->getMessage()], 500);
        }
    }

    public function myNotifications(): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        $notifications = $this->notificationService->getByUserId($userId);
        return response()->json($notifications, 200);
    }

    public function markAsRead(int $id): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        $notification = $this->notificationService->markAsRead($id, $userId);

        if (!$notification) {
            return response()->json(['message' => 'Notificação não encontrada.'], 404);
        }

        return response()->json($notification, 200);
    }
}
