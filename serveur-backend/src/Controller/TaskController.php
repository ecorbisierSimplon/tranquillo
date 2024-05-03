<?php

namespace App\Controller;

use App\Dto\TaskDto;
use App\Entity\User;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
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

    #[Route(['', '/'], name: 'app_api_task_read_all', methods: ['GET'])]
    #[IsGranted('ROLE_WEBMASTER')]
    public function readAll()
    {
        return  $this->service->findAll();
    }

    #[Route('/list', name: 'app_api_task_read_all', methods: ['GET'])]
    public function read(): JsonResponse
    {
        return  $this->service->findByUserField($this->isUserExist());
    }

    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'app_api_task_read_one', methods: ['GET'])]
    public function readOne($id): JsonResponse
    {
        return $this->service->findOne($id);
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

    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'app_api_task_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        return $this->service->delete($id, $this->isUserExist());
    }



    // #[Route('/{id}/edit', name: 'app_api_tasks_edit', methods: ['PUT'])]
    // public function edit(Request $request, Task $tpaTask, EntityManagerInterface $entityManager): void
    // {
    // }

    private function isUserExist()
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('Impossible de récupérer l\'utilisateur.');
        }
        return $user->getId();
    }
}
