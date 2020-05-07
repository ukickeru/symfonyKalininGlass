<?php

namespace App\Service\Locale\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * Stores the locale of the user in the session after the
 * login. This can be used by the LocaleSubscriber afterwards.
 */
class ManuallySetLocale implements EventSubscriberInterface
{

    private $session;

    private $defaultLocale;
    private $enableLocalization;

    public function __construct(
        SessionInterface $session,
        $enableLocale,
        $defaultLocale
    )
    {
        $this->session = $session;
        $this->enableLocalization = $enableLocale;
        $this->defaultLocale = $defaultLocale;
    }

    public function onInteractiveLogin(
        InteractiveLoginEvent $event
    )
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($this->enableLocalization) {
            if (null !== $user->getLocale()) {
                $this->session->set('_locale', $user->getLocale());
            } else {
                $this->session->set('_locale', $this->defaultLocale);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

}