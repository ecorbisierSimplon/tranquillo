<?php
// src/App/EventListener/UsersJWTResponsesListener.php

namespace App\EventListener;

use App\Dto\UserDto;
use App\Entity\User;
use App\Helper\ObjectHydrator;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

final class UsersJWTResponsesListener extends AbstractController
{


    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = ObjectHydrator::hydrate($event->getUser(), new UserDto);

        if (!$user instanceof UserDto) {
            return;
        }

        $data['user'] = $this->jsonEncode(
            $user,
            ['groups' => ['users: read']]
        );
        $data['code'] = Response::HTTP_ACCEPTED;


        // array(
        //     // 'roles' => $user->getRoles(),
        //     "message" => "Bienvenue"
        // );

        $event->setData($data);
    }

    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'status'  => "Accès interdit",
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
            'status'  => "Accès refusé",
            'message' => "Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau.",
        ];

        $response = new JWTAuthenticationFailureResponse("Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau.", Response::HTTP_UNAUTHORIZED);
        $response->setData($data);

        $event->setResponse($response);
    }



    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = [
            'status'  => "Token non accepter",
            'message' => "Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau.",
        ];

        $response = new JWTAuthenticationFailureResponse("Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau.", Response::HTTP_NOT_ACCEPTABLE);
        $response->setData($data);

        $event->setResponse($response);
    }


    /**
     * Returns a Json that uses the serializer component if enabled, or json_encode.
     *
     * @param int $status The HTTP status code (200 "OK" by default)
     */
    private function jsonEncode(mixed $data, array $context = []): mixed
    {
        if ($this->container->has('serializer')) {
            $json = $this->container->get('serializer')->serialize($data, 'json', array_merge([
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ], $context));

            return $json;
        }
        return $data;
    }
}
