<?php
// src/App/EventListener/UsersJWTCreatedListener.php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTEncodedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;


final class UsersJWTCreatedListener extends AbstractController
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        // Récupérer le User-Agent de la requête client
        $userAgent = $request->headers->get('User-Agent');

        // Récupérer les données et les en-têtes du JWT
        $payload = $event->getData();
        $header = $event->getHeader();

        // Ajouter le User-Agent au payload si vous en avez besoin
        $payload['ip'] = $request->getClientIp();
        // Ajouter le User-Agent au header du JWT
        $payload['cty'] = "JWTTranquillo";
        $payload['User-Agent'] = $userAgent;

        // Définir les nouvelles données et en-têtes pour le JWT
        $event->setData($payload);
        // $event->setHeader($header);

        // Définir la date d'expiration du JWT
        $expiration = new \DateTime('+30 day');
        $expiration->setTime(2, 0, 0);
        $payload['exp'] = $expiration->getTimestamp();
        $event->setData($payload);
    }


    /**
     * @param JWTDecodedEvent $event
     *
     * @return void
     */
    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $userAgent = $request->headers->get('User-Agent');
        $userCty = $request->headers->get('cty');

        $payload = $event->getPayload();

        if (!isset($payload['ip']) || $payload['ip'] !== $request->getClientIp()) {
            $event->markAsInvalid();
        }
        if (!isset($payload['cty']) || $payload['cty'] !== $userCty) {
            $event->markAsInvalid();
        }
        if (!isset($payload['User-Agent']) || $payload['User-Agent'] !== $userAgent) {
            $event->markAsInvalid();
        }
    }


    /**
     * @param JWTEncodedEvent $event
     */
    public function onJwtEncoded(JWTEncodedEvent $event)
    {
        $token = $event->getJWTString();
    }
}
