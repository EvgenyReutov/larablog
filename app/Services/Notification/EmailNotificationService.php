<?php

namespace App\Services\Notification;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService implements NotificationService
{

    public function notify(int $userId, string $text): void
    {
        Mail::raw('Notification to userId = '. $userId. ", text = $text",
        function (Message $mail) {
            $mail->to('admin@localhost.com')
            ->subject('New post is created');
        });
    }
}
