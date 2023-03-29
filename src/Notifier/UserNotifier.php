<?php

namespace App\Notifier;

use App\Notifier\Factory\MetaFactory;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class UserNotifier
{
    public function __construct(
        protected readonly NotifierInterface $notifier,
        protected MetaFactory $factory
    ) {}

    public function sndNotification(string $message/*, User $user*/): void
    {
        $user = new class {
            public function getPreferredChannel(): string {
                return 'slack';
            }
            public function getEmail(): string {
                return 'test@test.com';
            }
            public function getPhoneNumber(): string {
                return '0000000';
            }
        };

        $notification = $this->factory->createNotification($message, $user->getPreferredChannel());

        $this->notifier->send($notification, new Recipient($user->getEmail(), $user->getPhoneNumber()));
    }
}
