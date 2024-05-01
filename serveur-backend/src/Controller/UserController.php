<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/user', name: 'app_user')]
class UserController extends AbstractController
{
    #[Route(['', '/'], name: 'app_api_user_read_me', methods: ['GET'])]
    public function readMe(UserService $userFind): JsonResponse
    {
        $id = 65;
        return  $userFind->findOne($id);
    }



    #[Route(['', '/'], requirements: ["id" => "(\d+)"], name: 'app_api_user_delete_me', methods: ['DELETE'])]
    public function deleteMe(UserService $userFind): JsonResponse
    {
        $id = 70;
        return $userFind->delete($id);
    }


    #[Route(['', '/'], name: 'app_api_user_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(
            serializationContext: ['users: create']
        )]
        UserDto $userDto,
        UserService $userFind
    ): JsonResponse {
        return $userFind->create($userDto);
    }


    // #[Route(['', '/'], name: 'app_api_users_edit_me', methods: ['PUT'])]
    // public function edit(Request $request, User $tpaUser, EntityManagerInterface $entityManager): void
    // {
    // }

}
