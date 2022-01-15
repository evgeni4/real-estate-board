<?php

namespace App\Subscribers\CurrencyLocale;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleCurrency implements  EventSubscriberInterface
{

    public function __construct(public string $defaultCurrency = 'EUR' )
    {
    }
    public function onCurrencyRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->hasPreviousSession()) {
            return;
        }

        if ($currency = $request->query->get('_currency')) {
            $request->setDefaultCurrencylocale($currency);
        } else {
            $request->setDefaultCurrencylocale($request->getSession()->get('_currency', $this->defaultCurrency));
        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onCurrencyRequest', 20]],
        ];
    }
}