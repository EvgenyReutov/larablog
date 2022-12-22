<?php

namespace App\Services\Notification;

use Illuminate\Log\LogManager;

class LogNotificationService implements NotificationService
{
    public function __construct(private LogManager $logManager, private $count)
    {

    }

    public function notify(int $userId,string $text): void
    {
        for ($i = 0; $i < $this->count; $i++) {
            $this->
            logManager
                ->info('Notification to userId = '. $userId. ", text = $text");
        }

    }
}
