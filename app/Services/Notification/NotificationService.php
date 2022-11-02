<?php

namespace App\Services\Notification;

interface NotificationService
{
    public function notify(int $userId, string $text): void;
}
