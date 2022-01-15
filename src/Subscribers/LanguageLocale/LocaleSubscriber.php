<?php

namespace App\Subscribers\LanguageLocale;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public function __construct(public string $defaultLocale = 'en')
    {
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }
        if ($locale = $request->query->get('_locales')) {
            $request->setLocale($locale);
        } else {
            $request->setLocale($request->getSession()->get('_locales', $this->defaultLocale));
        }

    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}