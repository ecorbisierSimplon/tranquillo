<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\TransactionRequiredException;
use Doctrine\ORM\Exception\ORMException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('api/user', name: 'app_user')]
class UserController extends AbstractController
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
     *
     * @param UserService $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Cette fonction PHP récupère l'utilisateur actuel et renvoie ses informations au format JSON avec des
     * groupes de sérialisation spécifiques.
     *
     * @return JsonResponse La méthode `readme()` renvoie l'objet utilisateur sous forme de réponse JSON
     * avec le code d'état 200 (HTTP OK). L'objet utilisateur est sérialisé avec le groupe de sérialisation
     * « users : show », ce qui signifie que seules les propriétés de l'entité utilisateur qui font partie
     * de ce groupe de sérialisation seront incluses dans la réponse JSON.
     */
    #[Route(['', '/'], name: 'app_api_users_readme', methods: ['GET'])]
    public function readMe(): JsonResponse
    {
        $user = $this->getUser();
        // return $user;
        if (!$user instanceof UserInterface) {
            throw new \LogicException('Impossible de récupérer l\'utilisateur.');
        }

        return $this->json($user, Response::HTTP_OK, [], [
            'groups' => ['users: read']
        ]);
    }



    /**
     * Cette fonction PHP supprime un utilisateur avec l'ID 70 à l'aide d'une requête DELETE.
     *
     * @param UserService userFind Le paramètre `userFind` dans la méthode `deleteMe` est une instance
     * de la classe `UserService`. Il est utilisé pour effectuer l'opération de suppression pour un
     * utilisateur avec l'ID spécifié comme 70 dans ce cas. La méthode `delete` de la classe
     * `UserService` est probablement responsable
     *
     * @return JsonResponse Une JsonResponse est renvoyée par la méthode deleteMe.
     *
     * @param mixed $id
     * @return JsonResponse
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    #[Route(['', '/'], name: 'app_api_user_delete_me', methods: ['DELETE'])]
    public function deleteMe(mixed $user): JsonResponse
    {
        $user instanceof \App\Entity\User;
        $user = $this->getUser();

        // return $user;
        if (!$user instanceof User) {
            throw new \LogicException('Impossible de récupérer l\'utilisateur.');
        }

        return $this->service->delete($user->getId());
    }


    /**
     * Cette fonction PHP crée un nouvel utilisateur à l'aide d'un objet UserDto et d'une instance
     * UserService.
     *
     * @param UserDto userDto Le paramètre `` dans la méthode `create` est un paramètre
     * d'indication de type de type `UserDto`. Il est transmis à la méthode dans le cadre des données
     * utiles de la demande. L'attribut `MapRequestPayload` est utilisé pour mapper les données de la
     * demande entrante au `UserDto
     * @param UserService userFind  est une instance de la classe UserService, chargée de
     * gérer la création d'un nouvel utilisateur en fonction des données fournies dans l'objet UserDto.
     * La méthode create du service  est appelée avec l'objet  comme paramètre pour
     * lancer le processus de création d'utilisateur.
     *
     * @return JsonResponse Une JsonResponse est renvoyée.
     *
     * @param UserDto $userDto
     * @return JsonResponse
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws ORMException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[Route(['', '/'], name: 'app_api_user_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(
            serializationContext: ['users: create']
        )]
        UserDto $userDto
    ): JsonResponse {
        return $this->service->create($userDto);
    }


    #[Route(['', '/'], name: 'app_api_users_edit_me', methods: ['PUT'])]
    public function edit(User $user): void
    {
    }
}
