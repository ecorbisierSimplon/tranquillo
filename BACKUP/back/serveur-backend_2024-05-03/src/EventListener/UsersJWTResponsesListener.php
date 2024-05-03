<?php
// src/App/EventListener/UsersJWTResponsesListener.php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

final class UsersJWTResponsesListener
{


    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['data'] = array(
            // 'roles' => $user->getRoles(),
            "message" => "Bienvenue"
        );

        $event->setData($data);
    }

    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'status'  => '403 Accès refusé',
            'message' => "Mauvaises informations d'identification, veuillez vérifier que votre nom d'utilisateur/mot de passe sont correctement définis.",
        ];

        $response = new JWTAuthenticationFailureResponse("Mauvaises informations d'identification, veuillez vérifier que votre nom d'utilisateur/mot de passe sont correctement définis.", JsonResponse::HTTP_FORBIDDEN);
        $response->setData($data);

        $event->setResponse($response);
    }

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $data = [
            'status'  => '401 Accès non autorisé',
            'message' => "Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau.",
        ];

        $response = new JWTAuthenticationFailureResponse("Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau.", JsonResponse::HTTP_UNAUTHORIZED);
        $response->setData($data);

        $event->setResponse($response);
    }



    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = [
            'status'  => '404 Accès incorrect',
            'message' => "Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau",
        ];

        $response = new JWTAuthenticationFailureResponse("Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau.", JsonResponse::HTTP_NOT_FOUND);
        $response->setData($data);

        $event->setResponse($response);
    }
}
