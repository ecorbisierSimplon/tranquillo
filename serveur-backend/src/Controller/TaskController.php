<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\TaskDto;
use App\Entity\Task;
use App\Security\Voter\TasksVoter;
use App\Security\Voter\TaskVoter;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('api/task', name: 'app_task')]
class TaskController extends AbstractController
{
    private $service;

    /**
     * La fonction ci-dessus est un constructeur en PHP qui initialise un objet TaskService.
     * 
     * @param TaskService service Le paramètre « service » dans le constructeur est une instance de la
     * classe TaskService. Cela signifie que lorsqu'un objet de cette classe est créé, il nécessite
     * qu'une instance de la classe TaskService soit transmise en tant que dépendance. Il s'agit d'une
     * pratique courante en programmation orientée objet consistant à injecter des dépendances dans les
     * classes plutôt que
     */
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    #[Route('/', name: 'app_api_task_read_all', methods: ['GET'])]
    public function readAll(): JsonResponse
    {
        return  $this->service->findAll();
    }

    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'app_api_task_read_one', methods: ['GET'])]
    #[IsGranted(TaskVoter::VIEW, subject: 'task')]
    public function readOne($id, Task $task): JsonResponse
    {
        return $this->service->findOne($id);
    }


    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'app_api_task_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            throw new \LogicException('Impossible de récupérer l\'utilisateur.');
        }
        return $this->service->delete($id, $user);
    }


    #[Route(['', '/'], name: 'app_api_task_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(
            serializationContext: ['tasks: create']
        )]
        TaskDto $taskDto,

    ): JsonResponse {
        return $this->service->create($taskDto);
    }


    // #[Route('/{id}/edit', name: 'app_api_tasks_edit', methods: ['PUT'])]
    // public function edit(Request $request, Task $tpaTask, EntityManagerInterface $entityManager): void
    // {
    // }

}
