<?php

namespace App\Controller;

use App\Entity\TpaUsers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;


#[Route('/api/users')]
class ApiUsersController extends AbstractController
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
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
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        // return $user;
        if (!$user instanceof UserInterface) {
            throw new \LogicException('Unable to retrieve user.');
        }

        return $this->json($user, Response::HTTP_OK, [], [
            'groups' => ['users:show']
        ]);
    }


    /**
     * Cette fonction PHP crée un nouvel utilisateur, hache le mot de passe, définit la date de création
     * et les rôles de l'utilisateur, conserve l'entité utilisateur et renvoie une réponse JSON avec les
     * données utilisateur créées.
     * 
     * @param TpaUsers user L'extrait de code que vous avez fourni est une méthode de contrôleur Symfony
     * pour créer un nouvel utilisateur. Laissez-moi vous détailler les paramètres :
     * @param EntityManagerInterface em Le paramètre "em" dans l'extrait de code signifie
     * EntityManagerInterface. Il s'agit d'une interface dans Doctrine ORM qui fournit des méthodes pour
     * interagir avec la base de données, telles que la persistance et le vidage des entités. Dans ce
     * contexte, il est utilisé pour conserver la nouvelle entité utilisateur () dans la base de
     * données à l'aide de la propriété persist
     * 
     * @return La méthode `new` renvoie une réponse JSON avec l'entité utilisateur nouvellement créée.
     * La réponse inclut les données de l'entité utilisateur, le code d'état HTTP 201 (Créé), les
     * en-têtes vides et le contexte de sérialisation spécifiant les groupes à inclure dans la réponse.
     */
    #[Route(['', '/'], name: 'app_api_users_new', methods: ['POST'])]
    public function new(
        #[MapRequestPayload(
            serializationContext: ['users:create', 'users:at']
        )]
        TpaUsers $user,
        EntityManagerInterface $em
    ) {

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $user->getPassword()));
        $user->setUserCreateAt(new \DateTimeImmutable());
        $user->setRoles(['ROLE_USER']);
        $em->persist($user);
        $em->flush();
        return $this->json($user, Response::HTTP_CREATED, [], [
            'groups' => ['users:show']
        ]);
    }

    #[Route(['', '/'], name: 'app_api_users_editme', methods: ['PUT'])]
    public function  edit(
        #[MapRequestPayload(
            serializationContext: ['users:update']
        )]
        TpaUsers $user,
        EntityManagerInterface $em
    ) {
        // Charger l'utilisateur existant depuis la base de données
        $upUser = $this->getUser();


        $upUser->setEmail($user->getEmail());
        $upUser->setLastname($user->getLastname());
        $upUser->setFirstname($user->getFirstname());
        // $user->setUserCreateAt(new \DateTimeImmutable());
        // $user->setRoles(['ROLE_USER']);

        if (!$upUser) {
            return $this->json(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $em->persist($upUser);
        $em->flush();
        return $this->json($upUser, Response::HTTP_CREATED, [], [
            'groups' => ['users:show']
        ]);
    }
}
