<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;


class TaskService extends AbstractController
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function  findAll(): JsonResponse
    {
        // dd($this->taskRepository->findAll());
        return $this->json($this->taskRepository->findAll(), 200, [], [
            'groups' => ['tasks: read']
        ]);
    }

    public function findOne(Task $task)
    {
        return $this->json($task, 201, [], [
            'groups' => ['tasks: read']
        ]);
    }

    // public function findOneByUser(Task $user)
    // {
    // }

    public function delete(Task $task, EntityManagerInterface $entityManager): Response
    {
        // if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {
        $entityManager->remove($task);
        $entityManager->flush();
        // }
        $codeResponse = Response::HTTP_SEE_OTHER;
        $message = "La tache '" . $task->getName() .  "' a été supprimé de la base de données";

        $response = new JsonResponse(["title" => "Suppression utilisateur", "status" => $codeResponse, 'detail' => $message], $codeResponse);
        return $response;
    }
}
