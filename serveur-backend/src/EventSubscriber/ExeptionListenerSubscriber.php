<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExeptionListenerSubscriber implements EventSubscriberInterface
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $this->requestStack->getCurrentRequest();
        $entite = ($request->attributes->get('_route') === 'app_api_users_show') ? "L'utilisateur" : "L'entitée";

        // Vérifie si l'exception est une NotFoundHttpException et si le message contient une indication que l'ID est introuvable
        if ($exception instanceof NotFoundHttpException && strpos($exception->getMessage(), 'object not found by') !== false) {
            $message = "$entite avec cet ID n'existe pas.";

            // Modifier la réponse avec le message d'erreur personnalisé
            $codeResponse = Response::HTTP_NOT_FOUND;
            $response = new JsonResponse(["title" => "Une erreur s'est produite", "status" => $codeResponse, 'detail' => $message], $codeResponse);
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
