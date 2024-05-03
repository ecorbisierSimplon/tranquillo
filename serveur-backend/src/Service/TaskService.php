<?php

namespace App\Service;

use App\Dto\TaskDto;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;


class TaskService extends AbstractController
{
    private $taskRepository;
    private $em;

    /**
     * @param TaskRepository $taskRepository
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $entityManager)
    {
        $this->taskRepository = $taskRepository;
        $this->em = $entityManager;
    }

    // ##########################################
    // ----------------- CREATE ----------------
    // ##########################################

    /**
     * @param TaskDto $taskDto
     * @return (Task|int)[]|(null|string|int)[]
     */
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

            return ["task" => $task->getId(), "code" => Response::HTTP_CREATED];
        }
        $title = "Not found";
        $message = "The task '" . $taskDto->getName() . "' has existed since " . $taskCreateAt->format('d/m/Y') . " at " . $taskCreateAt->format('H:m:s');
        return ["task" => null, "title" => $title, "code" => 400, "message" => $message];
    }


    // ##########################################
    // ----------------- GET -------------------
    // ##########################################

    /**
     * ------------  read all ----------------
     * @return array
     */
    public function  findAll(): array /* Task */
    {
        $task = $this->taskRepository->findAll();
        if ($task === null) {
            $title = "Tasks not found";
            $message = "There are no tasks at all.";
            return ["task" => null, "title" => $title, "code" => Response::HTTP_NOT_FOUND, "message" => $message];
        }
        return ["task" => $task];
    }

    /**
     * ------------  read list ----------------
     *
     * @param mixed $id
     * @return array
     */
    public function findByUserField($id): array /* Task */
    {
        $task = $this->taskRepository->findByUserField($id);

        if ($task === null) {
            $title = "Tasks not found";
            $message = "You have not tasks";
            return ["task" => null, "title" => $title, "code" => Response::HTTP_NOT_FOUND, "message" => $message];
        }
        return ["task" => $task, "code" => Response::HTTP_ACCEPTED];
    }

    /**
     * ------------  read one ----------------
     *
     * @param mixed $id
     * @return array
     */
    public function findOne($id): array /* Task */
    {
        $task[] = $this->taskRepository->findOneByTask('id', $id);

        if ($task === null) {
            $title = "Not found";
            $message = "The task doesn't exist";
            return ["task" => null, "title" => $title, "code" => Response::HTTP_NOT_FOUND, "message" => $message];
        }
        return ["task" => $task, "code" => Response::HTTP_ACCEPTED];
    }


    // ##########################################
    // ----------------- GET -------------------
    // ##########################################

    /**
     * @param mixed $id
     * @param mixed $userId
     * @return array
     */
    public function delete($id, $userId): array /* Task */
    {
        $task = $this->taskRepository->findOneByTask('id', $id);
        $title = "Delete is rejected";
        $codeResponse = Response::HTTP_NOT_FOUND;

        if ($task === null) {
            $message = "The task you want to delete does not exist";
        } elseif ($task === 404) {
            $message = "The entity you call does not exist";
        } else {
            if ($task->getUsersId() == $userId) {
                $this->em->remove($task);
                $this->em->flush();
                $codeResponse = Response::HTTP_ACCEPTED;
                $title = "Delete a task";
                $message = "The task '" . $task->getName() .  "', creates the " . $task->getCreateAt()->format('d/m/Y') .  ", has been deleted";
            } else {
                $codeResponse = Response::HTTP_FORBIDDEN;
                $message = "This is not your task";
            }
        }
        return ["title" => $title, "code" => $codeResponse, 'detail' => $message];
    }


    // ##########################################
    // ----------------- PRIVATE ---------------
    // ##########################################


    /**
     * @param TaskDto $taskDto
     * @return Task
     */
    public function ifExist(TaskDto $taskDto)
    {
        return $this->taskRepository->findExistingTask(
            $taskDto->getName(),
            new \DateTimeImmutable()
        );
    }
}
