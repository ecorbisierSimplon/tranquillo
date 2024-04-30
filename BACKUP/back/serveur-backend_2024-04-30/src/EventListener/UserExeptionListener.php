<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserExeptionListener
{
    private $requestStack;
    private $translator;

    public function __construct(RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->requestStack = $requestStack;
        $this->translator = $translator;
    }

    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->attributes->get('_route');
        $entity = ($route === 'app_api_users_show') ? "L'utilisateur" : "L'entitée";
        $title = "Erreur critique";
        $message = "Une erreur critique s'est produite !";
        $codeResponse = Response::HTTP_INTERNAL_SERVER_ERROR;
        $customError = false;

        // Vérifie si l'exception est une NotFoundHttpException et si le message contient une indication que l'ID est introuvable
        if ($exception instanceof NotFoundHttpException && strpos($exception->getMessage(), 'object not found by') !== false) {
            $title = "Non trouvé !";
            $message = "$entity avec cet ID n'existe pas.";
            $codeResponse = Response::HTTP_NOT_FOUND;
            $customError = true;
        } elseif ($exception instanceof AccessDeniedHttpException) {
            $title = "Accès refusé !";
            $message = "Vous n'avez pas les droits suffisants pour effectuer cette action !";
            $codeResponse = Response::HTTP_FORBIDDEN;
            $customError = true;
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            $title = "Non trouvé !";
            $message = "La route demandée est invalide !";
            $codeResponse = Response::HTTP_METHOD_NOT_ALLOWED;
            $customError = true;
        } elseif ($exception instanceof NotFoundHttpException) {
            $title = "Non trouvé !";
            $message = "Le chemin demandé est invalide !";
            $codeResponse = Response::HTTP_NOT_FOUND;
            $customError = true;
        } elseif ($exception instanceof UnsupportedMediaTypeHttpException || strpos($exception->getMessage(), 'Unsupported format') !== false) {
            $title = "Erreur  !";
            $message = "Le type de fichier multimédia n'est pas reconnu pas ou ne peut pas être accepté !";
            $codeResponse = Response::HTTP_UNSUPPORTED_MEDIA_TYPE;
            $customError = true;
        } else {
            $title = "Erreur  !";
            // $message = $this->translator->trans("this a error clear last", locale: 'fr_FR');
            $message = $exception->getMessage();
            $codeResponse = Response::HTTP_BAD_REQUEST;
            $customError = true;
        }
        if ($customError) {
            $response = new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
            $event->setResponse($response);
        }
    }
}
