<?php

namespace App\Controller;

use App\Dto\TaskDto;
use App\Service\TaskService;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    // #[Route('/{id}', name: 'app_api_users_delete', methods: ['DELETE'])]
    // public function delete(Request $request, Task $tpaUser, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {
    //         $entityManager->remove($tpaUser);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_api_users_index', [], Response::HTTP_SEE_OTHER);
    // }
}
