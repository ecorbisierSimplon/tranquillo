<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('api/admin/user', name: 'app_user')]
class UserAdminController extends AbstractController
{
    #[Route('/', name: 'app_api_user_read_all', methods: ['GET'])]
    public function readAll(UserService $userFind): JsonResponse
    {
        return  $userFind->findAll();
    }


    #[Route('/{id}', requirements: ["id" => "(\d+)"], name: 'app_api_user_read_one', methods: ['GET'])]
    public function readOne($id, UserService $userFind): JsonResponse
    {
        return $userFind->findOne($id);
    }

    #[IsGranted('ROLE_WEBMASTER')]
    #[Route('/{id}', requirements: ["id" => "(\d+)"], name: 'app_api_user_delete', methods: ['DELETE'])]
    public function delete($id, UserService $userFind): JsonResponse
    {
        return $userFind->delete($id);
    }


    // #[Route('/{id}/edit', name: 'app_api_users_edit', methods: ['PUT'])]
    // public function edit(Request $request, User $tpaUser, EntityManagerInterface $entityManager): void
    // {
    // }

}
