<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\UserDto;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\TransactionRequiredException;
use Doctrine\ORM\Exception\ORMException;
use RuntimeException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('api/admin/user', name: 'app_user')]
class UserAdminController extends AbstractController
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
     * La fonction `readAll` renvoie une JsonResponse contenant toutes les données utilisateur.
     *
     * @return JsonResponse Un objet `JsonResponse` est renvoyé par la méthode `readAll()`.
     *
     * @return JsonResponse
     * @throws RuntimeException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[Route('/', name: 'app_api_user_read_all', methods: ['GET'])]
    public function readAll(): JsonResponse
    {
        return  $this->service->findAll();
    }


    /**
     * Cette fonction PHP lit et renvoie un utilisateur spécifique par son identifiant.
     *
     * @param id Le paramètre "id" dans l'extrait de code représente un identifiant unique pour un
     * utilisateur. Il devrait s'agir d'une valeur numérique comme indiqué par les exigences spécifiées
     * dans l'annotation d'itinéraire. Ce paramètre est utilisé pour récupérer et renvoyer des
     * informations sur un utilisateur spécifique identifié par l'ID fourni.
     *
     * @return JsonResponse Un objet JsonResponse est renvoyé, qui est susceptible de contenir les
     * données d'un utilisateur spécifique avec l'ID donné. Les données sont récupérées en appelant la
     * méthode `findOne` de la classe de service.
     *
     * @param mixed $id
     * @return JsonResponse
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws ORMException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'app_api_user_read_one', methods: ['GET'])]
    public function readOne($id): JsonResponse
    {
        return $this->service->findOne($id);
    }

    /**
     * Cette fonction PHP est chargée de supprimer un utilisateur avec un identifiant spécifique et
     * nécessite l'autorisation 'ROLE_WEBMASTER' pour y accéder.
     *
     * @param id Le paramètre `id` dans l'extrait de code représente l'identifiant unique de
     * l'utilisateur que vous souhaitez supprimer. Cet identifiant devrait être une valeur numérique
     * comme l'indique l'exigence de route `(\d+)`, qui spécifie que `id` doit être un chiffre.
     *
     * @return JsonResponse Une JsonResponse est renvoyée par la méthode delete.
     *
     * @param mixed $id
     * @return JsonResponse
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    #[IsGranted('ROLE_WEBMASTER')]
    #[Route('/{id}', requirements: ["id" => Requirement::DIGITS], name: 'app_api_user_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        return $this->service->delete($id);
    }


    // #[Route('/{id}/edit', name: 'app_api_users_edit', methods: ['PUT'])]
    // public function edit(Request $request, User $tpaUser, EntityManagerInterface $entityManager): void
    // {
    // }

}
