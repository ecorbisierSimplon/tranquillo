<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Helper\ObjectHydrator;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
#[Route('api/user', name: 'app_user')]
final class UserController extends AbstractController
{
    private $service;

    /**
     * La fonction ci-dessus est un constructeur en PHP qui initialise un objet UserService.
     *
     * @param UserService service Le paramètre « service » dans le constructeur est une instance de la
     * classe UserService. Cela signifie que lorsqu'un objet de cette classe est créé, il nécessite
     * qu'une instance de la classe UserService soit transmise en tant que dépendance. Il s'agit d'une
     * pratique courante en programmation orientée objet consistant à injecter des dépendances dans les
     * classes plutôt que
     */
    public function __construct(UserService $service)
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
    #[Route(['', '/'], name: 'user_create', methods: ['POST'])]
    public function create(#[MapRequestPayload(serializationContext: ['users: create'])] UserDto $userDto): JsonResponse
    {
        /**
         * Appelle la méthode `create` de la
         * classe `UserService` et passe l'objet `UserDto` en paramètre.
         * Cette méthode est responsable
         * de la création d'un nouvel utilisateur basé sur les données
         * fournies dans l'objet `UserDto`.
         */
        $response = $this->service->create($userDto);

        /**
         * Vérifie si la clé 'user' dans le tableau `$response` est nulle.
         * Si elle est nulle, cela signifie que le processus de création d'utilisateur
         * n'a pas réussi ou que les données utilisateur n'ont pas été trouvées.
         * Dans ce cas, la méthode `getError()` est appelée pour renvoyer une réponse JSON
         * avec des détails sur l'erreur survenue lors du processus de création d'utilisateur.
         */
        if ($response['user'] == null) {
            return $this->getError($response);
        }


        /**
         * Appelle la méthode `findOne` de la classe `UserService`
         * qui est utilisée pour récupérer l'utilisateur
         * qui vient d'être créée depuis la bdd.
         */
        $response = $this->service->findOne($response['user']);
        $codeHttp = intval($response['code']);
        $response = $response['user'][0];

        /**
         * Utilise une méthode appelée `hydrate` de la classe `ObjectHydrator`
         * pour remplir un objet `UserDto` avec les données de la bdd.
         */
        $userDto = ObjectHydrator::hydrate(
            $response,
            new UserDto()
        );

        return $this->json(
            $userDto,
            $codeHttp,
            [],
            ['groups' => ['users: create']]
        );
    }

    // ##########################################
    // ----------------- GET -------------------
    // ##########################################



    /**
     * ------------  read one ----------------
     * @return JsonResponse
     *
     */
    #[Route(['', '/'], name: 'user_read_one', methods: ['GET'])]
    public function readOne(): JsonResponse
    {
        /**
         * Appelle la méthode `findOne` de la classe `UserService` avec deux paramètres :
         * `0` pour indiquer qu'il s'agit de l'utilisateur courant,
         * et `getThisUser()` qui renvoie l'id de l'utilisateur connecté.
         */
        $response = $this->service->findOne($this->getThisUser());

        /**
         * Vérifie si la clé 'user' dans le tableau `$response` est nulle.
         * Si elle est nulle, cela signifie que le processus de création d'utilisateur
         * n'a pas réussi ou que les données utilisateur n'ont pas été trouvées.
         * Dans ce cas, la méthode `getError()` est appelée pour renvoyer une réponse JSON
         * avec des détails sur l'erreur survenue lors du processus de création d'utilisateur.
         */
        if ($response['user'] == null || $response['user'] == 404) {
            return $this->getError($response);
        }

        /**
         * Utilise une méthode appelée `hydrate` de la classe `ObjectHydrator`
         * pour remplir un objet `UserDto` avec les données de la bdd.
         */
        $response = $response['user'];
        $userDto = ObjectHydrator::hydrate(
            $response,
            new UserDto()
        );

        $codeHttp = intval(Response::HTTP_ACCEPTED);
        return $this->json(
            $userDto,
            $codeHttp,
            [],
            ['groups' => ['users: read']]
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
    // #[Route(['', '/'], name: 'users_edit', methods: ['PUT'])]
    // public function edit(): void
    // {
    // }

    // ##########################################
    // ----------------- DELETE ----------------
    // ##########################################
    /**
     * ------------  delete  ----------------
     * @return JsonResponse
     *
     */
    #[Route(['', '/'],  name: 'user_delete', methods: ['DELETE'])]
    public function delete(): JsonResponse
    {
        /**
         * Appelle la méthode `delete` de la classe `UserService` avec deux paramètres :
         * `0` pour indiquer qu'il s'agit de l'utilisateur courant,
         * et `getThisUser()` qui renvoie l'id de l'utilisateur connecté.
         */
        $response = $this->service->delete($this->getThisUser());

        /**
         * La méthode `getError()` est appelée pour renvoyer une réponse JSON
         * avec des détails survenue lors du processus de création d'utilisateur,
         * AVEC OU SANS ERREUR.
         */
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
