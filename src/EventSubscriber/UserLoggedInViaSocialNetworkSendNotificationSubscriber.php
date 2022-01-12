<?php

namespace App\EventSubscriber;

use App\Event\UserLoggedInViaSocialNetworkEvent;
use App\Service\Mailer\Sender\UserLoggedInViaSocialNetworkEmailSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserLoggedInViaSocialNetworkSendNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(public UserLoggedInViaSocialNetworkEmailSender $emailSender)
    {
    }

    public function onUserLoggedInViaSocialNetworkEvent(UserLoggedInViaSocialNetworkEvent $event)
    {
        $user = $event->getUser();
        $plainPassword = $event->getPlainPassword();
        $this->emailSender->sendEmailToClient($user,$plainPassword);
    }

    public static function getSubscribedEvents()
    {
        return [
            UserLoggedInViaSocialNetworkEvent::class => 'onUserLoggedInViaSocialNetworkEvent'
        ];
    }
}