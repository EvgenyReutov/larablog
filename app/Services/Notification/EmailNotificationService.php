<?php

namespace App\Services\Notification;

use Illuminate\Log\LogManager;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Psr\Log\LoggerInterface;

class EmailNotificationService implements NotificationService
{
    private LoggerInterface $logger;

    public function __construct(LogManager $logger)
    {
        $this->logger = $logger->channel('single');
    }

    public function notify(int $userId, string $text): void
    {
        Mail::raw('Notification to userId = '. $userId. ", text = $text",
        function (Message $mail) {
            $mail->to('admin@localhost.com')
            ->subject('New post is created');
        });

        $this->logger->debug('Notification email has sent');
    }
}
