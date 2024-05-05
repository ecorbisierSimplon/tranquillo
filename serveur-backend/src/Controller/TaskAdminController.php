<?php

namespace App\Controller;

use App\Dto\TaskDto;
use App\Entity\User;
use App\Helper\ObjectHydrator;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
#[IsGranted('ROLE_WEBMASTER')]
#[Route('api/admin/task', name: 'app_task_admin')]
final class TaskAdminController extends AbstractController
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


    // ##########################################
    // ----------------- GET -------------------
    // ##########################################
    /**
     * ------------  read all ----------------
     * @return JsonResponse
     *
     */
    #[Route(['', '/'], name: 'task_read_all', methods: ['GET'])]
    public function readAll(): JsonResponse
    {
        $response = $this->service->findAll();
        $response = $response['task'];

        if ($response == null) {
            return $this->getError($response);
        }

        $taskDto = ObjectHydrator::hydrate(
            $response,
            new TaskDto()
        );

        $codeHttp = intval(Response::HTTP_ACCEPTED);
        return $this->json(
            $taskDto,
            $codeHttp,
            [],
            ['groups' => ['tasks: read']]
        );
    }

    /**
     * ------------  read one ----------------
     * @return JsonResponse
     *
     */
    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'task_read_one', methods: ['GET'])]
    public function readOne($id): JsonResponse
    {
        $response = $this->service->findOne($id, 'ROLE_WEBMASTER');
        if ($response['task'] == null || $response['task'] == 404) {
            return $this->getError($response);
        }

        $response = $response['task'];
        $taskDto = ObjectHydrator::hydrate(
            $response,
            new TaskDto()
        );

        $codeHttp = intval(Response::HTTP_ACCEPTED);
        return $this->json(
            $taskDto,
            $codeHttp,
            [],
            ['groups' => ['tasks: read']]
        );
    }



    // ##########################################
    // ----------------- DELETE ----------------
    // ##########################################
    /**
     * ------------  delete  ----------------
     * @return JsonResponse
     *
     */
    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'task_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $response = $this->service->delete($id, 'ROLE_WEBMASTER');
        return $this->getError($response);
    }

    // ##########################################
    // ----------------- PRIVATE ---------------
    // ##########################################


    private function getError($response): JsonResponse
    {
        return new JsonResponse(
            [
                "title" => $response['title'],
                "status" => intval($response['code']),
                "detail" => $response['message']
            ],
            intval($response['code'])
        );
    }
}
