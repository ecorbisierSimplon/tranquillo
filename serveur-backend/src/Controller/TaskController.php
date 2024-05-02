<?php

namespace App\Controller;

use App\Dto\TaskDto;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/task', name: 'app_task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_api_task_read_all', methods: ['GET'])]
    public function readAll(TaskService $taskFind): JsonResponse
    {
        return  $taskFind->findAll();
    }


    #[Route('/{id}', requirements: ["id" => "(\d+)"], name: 'app_api_task_read_one', methods: ['GET'])]
    public function readOne($id, TaskService $taskFind): JsonResponse
    {
        return $taskFind->findOne($id);
    }


    #[Route('/{id}', requirements: ["id" => "(\d+)"], name: 'app_api_task_delete', methods: ['DELETE'])]
    public function delete($id, TaskService $taskFind): JsonResponse
    {
        return $taskFind->delete($id);
    }


    #[Route(['', '/'], name: 'app_api_task_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(
            serializationContext: ['tasks: create']
        )]
        TaskDto $taskDto,
        TaskService $taskFind
    ): JsonResponse {
        return $taskFind->create($taskDto);
    }


    // #[Route('/{id}/edit', name: 'app_api_users_edit', methods: ['PUT'])]
    // public function edit(Request $request, Task $tpaUser, EntityManagerInterface $entityManager): void
    // {
    // }

}
