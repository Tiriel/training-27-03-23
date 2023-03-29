<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\MailNotification;
use Symfony\Component\Notifier\Notification\Notification;

class EmailNotificationFactory implements NotificationFactoryInterface, IterableFactoryInterface
{

    public function createNotification(string $message): Notification
    {
        return new MailNotification($message);
    }

    public static function getDefaultIndexName(): string
    {
        return 'mail';
    }
}
