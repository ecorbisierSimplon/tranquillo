<?php
// src/Controller/LoginController.php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    private $jwtManager;
    private $userProvider;

    public function __construct(JWTTokenManagerInterface $jwtManager, UserProviderInterface $userProvider)
    {
        $this->jwtManager = $jwtManager;
        $this->userProvider = $userProvider;
    }

    #[Route('/login_check', name: 'app_login', methods: ['POST'])]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        try {
            // Load user by credentials
            $user = $this->userProvider->loadUserByUsername($username);

            // Check password
            if (!$user || !$this->checkPassword($user, $password)) {
                throw new AuthenticationException('Invalid credentials');
            }

            // Authentication succeeded, generate JWT token
            $token = $this->jwtManager->create($user);

            // Return token in response
            return $this->json(['token' => $token]);
        } catch (AuthenticationException $exception) {
            // Authentication failed, return error response
            return $this->json(['error' => $exception->getMessage()], 401);
        }
    }

    private function checkPassword(UserInterface $user, string $password): bool
    {
        // Implement your password checking logic here
        // For example, you can use Symfony's PasswordEncoder
        // to check if the provided password matches the user's hashed password

        return false;
    }
}
