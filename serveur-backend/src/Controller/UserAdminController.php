<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Helper\ObjectHydrator;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
#[Route('api/admin/user', name: 'app_user')]
final class UserAdminController extends AbstractController
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
    // ----------------- GET -------------------
    // ##########################################
    /**
     * ------------  read all ----------------
     * @return JsonResponse
     *
     */
    // FIXME: Tout lire sauf role hiérarchique SUPÉRIEUR
    #[Route(['', '/'], name: 'user_admin_read_all', methods: ['GET'])]
    public function readAll(): JsonResponse
    {
        $response = $this->service->findAll();
        $response = $response['user'];

        if ($response == null) {
            return $this->getError($response);
        }

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

    /**
     * ------------  read one ----------------
     * @return JsonResponse
     *
     */
    // FIXME: Lire utilisateur sauf role hiérarchique SUPÉRIEUR
    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'user_admin_read_one', methods: ['GET'])]
    public function readOne($id): JsonResponse
    {
        $response = $this->service->findOne($id);
        if ($response['user'] == null || $response['user'] == 404) {
            return $this->getError($response);
        }

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
    // #[Route('/{id}/edit', name: 'users_admin_edit', methods: ['PUT'])]
    // public function edit(Request $request, User $tpaUser, EntityManagerInterface $entityManager): void
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
    // FIXME:  Suppression utilisateur UNIQUEMENT si role hiérarchique INFÉRIEUR
    #[IsGranted('ROLE_WEBMASTER')]
    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'user_admin_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $response = $this->service->delete($id);
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
