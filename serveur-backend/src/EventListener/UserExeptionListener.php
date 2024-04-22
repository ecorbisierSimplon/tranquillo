<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class UserExeptionListener
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->attributes->get('_route');
        $entite = ($route === 'app_api_users_show') ? "L'utilisateur" : "L'entitée";

        // Vérifie si l'exception est une NotFoundHttpException et si le message contient une indication que l'ID est introuvable
        if ($exception instanceof NotFoundHttpException && strpos($exception->getMessage(), 'object not found by') !== false) {
            $message = "$entite avec cet ID n'existe pas.";

            // Modifier la réponse avec le message d'erreur personnalisé
            $codeResponse = Response::HTTP_NOT_FOUND;
            $response = new JsonResponse(["title" => "Une erreur s'est produite", "status" => $codeResponse, 'detail' => $message], $codeResponse);
            $event->setResponse($response);
        } elseif ($exception instanceof AccessDeniedHttpException && $exception->getMessage() === '_admin_') {
            $message = "Vous n'avez pas les droits suffisants pour voir les utilisateurs !";

            // Modifier la réponse avec le message d'erreur personnalisé
            $codeResponse = Response::HTTP_FORBIDDEN;
            $response = new JsonResponse(["title" => "Une erreur s'est produite", "status" => $codeResponse, 'detail' => $message], $codeResponse);
            $event->setResponse($response);
        }
    }
}
