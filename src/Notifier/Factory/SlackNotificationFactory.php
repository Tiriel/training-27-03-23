<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\SlackNotification;
use Symfony\Component\Notifier\Notification\Notification;

class SlackNotificationFactory implements NotificationFactoryInterface, IterableFactoryInterface
{

    public function createNotification(string $message): Notification
    {
        return new SlackNotification($message);
    }

    public static function getDefaultIndexName(): string
    {
        return 'slack';
    }
}
