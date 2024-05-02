<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\TransactionRequiredException;
use Doctrine\ORM\Exception\ORMException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

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
     * Cette fonction PHP lit les informations utilisateur avec l'ID spécifié à l'aide d'un objet
     * UserService.
     * 
     * @param UserService userFind Le paramètre `userFind` dans la méthode `readMe` est une instance de la
     * classe `UserService`. Il est utilisé pour rechercher et renvoyer un utilisateur avec l'ID 65 en
     * appelant la méthode « findOne » sur ce service. La méthode devrait renvoyer une `JsonResponse
     * 
     * @return JsonResponse La méthode `readMe` renvoie le résultat de l'appel de la méthode `findOne` sur
     * le service `` avec l'ID utilisateur de 65. La valeur de retour est un objet JsonResponse.
     */

    #[Route(['', '/'], name: 'app_api_user_read_me', methods: ['GET'])]
    public function readMe(UserService $userFind): JsonResponse
    {
        $id = 65;
        return  $userFind->findOne($id);
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
    #[Route(['', '/'], requirements: ["id" => "(\d+)"], name: 'app_api_user_delete_me', methods: ['DELETE'])]
    public function deleteMe($id): JsonResponse
    {

        return $this->service->delete($id);
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


    // #[Route(['', '/'], name: 'app_api_users_edit_me', methods: ['PUT'])]
    // public function edit(Request $request, User $tpaUser, EntityManagerInterface $entityManager): void
    // {
    // }

}
