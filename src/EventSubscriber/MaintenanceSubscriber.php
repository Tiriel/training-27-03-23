<?php

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private bool $isMaintenance;

    public function __construct(
        private readonly Environment $twig,
        private readonly RequestStack $stack,
        #[Autowire('%env(APP_MAINTENANCE)%')]
        bool $isMaintenance
    ) {
        $this->isMaintenance = $isMaintenance;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if ($this->isMaintenance) {
            $response = new Response();
            if ($this->stack->getMainRequest() === $request) {
                $response->setContent($this->twig->render('maintenance.html.twig'), 500);
                $event->setResponse($response);
            }
            $event->stopPropagation();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 9999],
        ];
    }
}
