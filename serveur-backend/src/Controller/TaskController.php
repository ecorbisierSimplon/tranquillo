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
#[Route('api/task', name: 'app_task')]
final class TaskController extends AbstractController
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
    // ----------------- POST -------------------
    // ##########################################
    /**
     * ------------  create ----------------
     * @return JsonResponse
     *
     */
    #[Route(['', '/'], name: 'task_create', methods: ['POST'])]
    public function create(#[MapRequestPayload(serializationContext: ['tasks: create'])] TaskDto $taskDto): JsonResponse
    {
        $response = $this->service->create($taskDto, $this->getThisUser(id: false));

        if ($response['task'] == null) {
            return $this->getError($response);
        }

        $response = $this->service->findOne($response['task'], $this->getThisUser());
        $codeHttp = intval($response['code']);
        $response = $response['task'][0];

        $taskDto = ObjectHydrator::hydrate(
            $response,
            new TaskDto()
        );

        return $this->json(
            $taskDto,
            $codeHttp,
            [],
            ['groups' => ['tasks: create']]
        );
    }

    // ##########################################
    // ----------------- GET -------------------
    // ##########################################

    /**
     * ------------  read list ----------------
     * @return JsonResponse
     *
     */
    #[Route(['/' | ''], name: 'task_read_list', methods: ['GET'])]
    public function readList(): JsonResponse
    {
        $response = $this->service->findByUserField($this->getThisUser());

        if ($response['task'] == null) {
            return $this->getError($response);
        }

        $taskDto['task'] = ObjectHydrator::hydrate(
            $response['task'],
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
        $response = $this->service->findOne($id, $this->getThisUser());
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
    // ----------------- UPDATE-----------------
    // ##########################################
    /**
     * ------------  put ------------------
     * @return JsonResponse
     *
     */
    #[Route(['', '/'], name: 'tasks_edit', methods: ['PUT'])]
    public function edit(#[MapRequestPayload(serializationContext: ['tasks: put'])] TaskDto $taskDto): JsonResponse
    {
        // dd($taskDto);

        /**
         * Appelle la méthode `create` de la
         * classe `TaskService` et passe l'objet `TaskDto` en paramètre.
         * Cette méthode est responsable
         * de la création d'un nouvel utilisateur basé sur les données
         * fournies dans l'objet `TaskDto`.
         */
        $response = $this->service->update($taskDto, $this->getThisUser());

        /**
         * Vérifie si la clé 'task' dans le tableau `$response` est nulle.
         * Si elle est nulle, cela signifie que le processus de création d'utilisateur
         * n'a pas réussi ou que les données utilisateur n'ont pas été trouvées.
         * Dans ce cas, la méthode `getError()` est appelée pour renvoyer une réponse JSON
         * avec des détails sur l'erreur survenue lors du processus de création d'utilisateur.
         */
        if ($response['task'] == null) {
            return $this->getError($response);
        }


        /**
         * Appelle la méthode `findOne` de la classe `TaskService`
         * qui est utilisée pour récupérer a tache
         * qui vient d'être modifiée depuis la bdd.
         */
        $response = $this->service->findOne($response['task'], $this->getThisUser());
        $codeHttp = intval($response['code']);
        $response = $response['task'][0];

        /**
         * Utilise une méthode appelée `hydrate` de la classe `ObjectHydrator`
         * pour remplir un objet `TaskDto` avec les données de la bdd.
         */
        $taskDto = ObjectHydrator::hydrate(
            $response,
            new TaskDto()
        );

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
        $response = $this->service->delete($id, $this->getThisUser());
        return $this->getError($response);
    }

    // ##########################################
    // ----------------- PRIVATE ---------------
    // ##########################################

    private function getThisUser(bool $id = true): int | User
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('Unable to recover the user.');
        }
        if ($id) {
            return $user->getId();
        }
        return $user;
    }

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
