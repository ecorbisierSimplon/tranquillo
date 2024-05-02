<?php

namespace App\Service;

use App\Dto\TaskDto;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



class TaskService extends AbstractController
{
    private $taskRepository;
    private $em;

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $entityManager)
    {
        $this->taskRepository = $taskRepository;
        $this->em = $entityManager;
    }

    public function  findAll(): JsonResponse
    {
        return $this->json($this->taskRepository->findAll(), 200, [], [
            'groups' => ['tasks: read']
        ]);
    }

    public function findOne($id): JsonResponse
    {
        $task = $this->taskRepository->findOneByTask('id', $id);

        if ($task === null) {
            $title = "Lecture impossible";
            $message = "La tache que vous voulez lire n'existe pas";
            $codeResponse = Response::HTTP_NOT_FOUND;
            return new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
        }
        return $this->json($task, 201, [], [
            'groups' => ['tasks: read']
        ]);
    }


    public function create(TaskDto $taskDto)
    {
        $taskCreateAt = new \DateTimeImmutable();
        $taskDto->setCreateAt($taskCreateAt);
        $existingTask = $this->ifExist($taskDto);

        if ($existingTask === null) {
            $task = new Task;
            $task->setName($taskDto->getName());
            $task->setDescription($taskDto->getDescription());
            $task->setReminder($taskDto->getReminder());
            $task->setStartAt($taskDto->getStartAt());
            $task->setEndAt($taskDto->getEndAt());
            $task->setCreateAt($taskDto->getCreateAt());

            $this->em->persist($task);
            $this->em->flush();
            return $this->json($task, Response::HTTP_CREATED, [], [
                'groups' => ['tasks: create']
            ]);
        }
        $title = "Création refusée";
        $message = "La tache '" . $taskDto->getName() . "' existe depuis le " . $taskCreateAt->format('d/m/Y') . " à " . $taskCreateAt->format('H:m:s');
        $codeResponse = Response::HTTP_BAD_REQUEST;
        return new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
    }

    public function delete($id): JsonResponse
    {
        // if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {

        $task = $this->taskRepository->findOneByTask('id', $id);
        $title = "Suppression refusée";
        $codeResponse = Response::HTTP_NOT_FOUND;

        if ($task === null) {
            $message = "La tache que vous voulez supprimer n'existe pas";
        } elseif ($task === 404) {
            $message = "L'entité que vous appelez n'existe pas";
        } else {

            $this->em->remove($task);
            $this->em->flush();
            $codeResponse = Response::HTTP_ACCEPTED;
            $title = "Suppression d'une tache";
            $message = "La tache '" . $task->getName() .  "', créée le " . $task->getCreateAt()->format('d/m/Y') .  ", a été supprimée de la base de données";
        }

        $response = new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
        return $response;
    }

    public function ifExist(TaskDto $taskDto)
    {
        $taskName = $taskDto->getName();
        $taskCreateAt = new \DateTimeImmutable();

        $existingTask = $this->taskRepository->findExistingTask($taskName, $taskCreateAt);

        return $existingTask;
    }
}
