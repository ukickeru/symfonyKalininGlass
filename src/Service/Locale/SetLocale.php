<?php

namespace App\Service\Locale;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Request;


class SetLocale
{

    private $defaultLocale;
    private $enableLocalization;

    public function __construct(
        $enableLocale,
        $defaultLocale
    )
    {
        $this->enableLocalization = $enableLocale;
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $requestEvent)
    {
        $request = $requestEvent->getRequest();

        if (!$request->hasPreviousSession() || !$this->enableLocalization) {
            return;
        }

        // try to see if the locale has been set as a _locale routing parameter
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

}