<?php

namespace App\Service;

use App\Dto\TaskDto;
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

    // public function findOneByTask(Task $task)
    // {
    // }
    public function
    create(
        TaskDto $taskDto,
        EntityManagerInterface $em
    ) {
        $task = new Task;
        $task->setName($taskDto->getName());
        $task->setDescription($taskDto->getDescription());
        $task->setReminder($taskDto->getReminder());
        $task->setStartAt($taskDto->getStartAt());
        $task->setEndAt($taskDto->getEndAt());
        $task->setCreateAt(new \DateTimeImmutable());

        $em->persist($task);
        $em->flush();
        return $this->json($task, Response::HTTP_CREATED, [], [
            'groups' => ['tasks: create']
        ]);
    }



    public function delete(Task $task, EntityManagerInterface $entityManager): Response
    {
        // if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {
        $entityManager->remove($task);
        $entityManager->flush();
        // }
        $codeResponse = Response::HTTP_ACCEPTED;
        $title = "Suppression d'une tache";
        $message = "La tache '" . $task->getName() .  "', créée le " . $task->getCreateAt()->format('d/m/Y') .  ", a été supprimée de la base de données";

        $response = new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
        return $response;
    }
}
