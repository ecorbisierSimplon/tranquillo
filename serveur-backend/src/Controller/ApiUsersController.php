<?php

namespace App\Controller;

use App\Entity\TpaUsers;
use App\Form\TpaUsersType;
use App\Repository\TpaUsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/api/users')]
class ApiUsersController extends AbstractController
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    #[Route('/', name: 'app_api_users_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: '_admin_')]
    public function index(TpaUsersRepository $tpaUsersRepository): JsonResponse
    {
        return $this->json($tpaUsersRepository->findAll(), 200, [], [
            'groups' => ['users:index']
        ]);
    }

    #[Route('/{id}', name: 'app_api_users_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: '_admin_')]
    public function show(TpaUsers $user): JsonResponse
    {
        return $this->json($user, 201, [], [
            'groups' => ['users:index', 'users:show']
        ]);
    }

    #[Route('/me', name: 'app_api_users_readme', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: '_user_')]
    public function readme(): Response
    {
        $user = $this->getUser();
        return $user;
        if (!$user instanceof UserInterface) {
            throw new \LogicException('Unable to retrieve user.');
        }

        return $this->json($user, 200, [], [
            'groups' => ['users:index', 'users:show']
        ]);
    }

    #[Route(['', '/'], name: 'app_api_users_new', methods: ['POST'])]
    public function new(
        Request $request,
        #[MapRequestPayload(
            serializationContext: ['users:create']
        )]
        TpaUsers $user,
        EntityManagerInterface $em
    ) {

        // $user->setPassword($this->userPasswordHasher->hashPassword($user, "PassWord:1234@"));
        // $user->setUserCreateAt(new \DateTimeImmutable());
        // $user->setRoles(['ROLE_USER']);
        // $em->persist($user);
        // $em->flush();
        return $this->json($user, 200, [], [
            'groups' => ['users:create', 'users:pass']
        ]);
    }

    #[Route('/me', name: 'app_api_users_editme', methods: ['PUT'])]
    #[IsGranted('ROLE_USER', message: '_user_')]
    public function edit(Request $request, TpaUsers $tpaUser, EntityManagerInterface $entityManager) //: JsonResponse
    {
        // $form = $this->createForm(TpaUsersType::class, $tpaUser);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager->flush();

        //     return $this->redirectToRoute('app_api_users_index', [], Response::HTTP_SEE_OTHER);
        // }

        // return $this->render('api_users/edit.html.twig', [
        //     'tpa_user' => $tpaUser,
        //     'form' => $form,
        // ]);
    }



    #[Route('/{id}', name: 'app_api_users_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_WEBMASTER', message: '_admin_')]
    public function delete(TpaUsers $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $lastname = $user->getLastname();
        $firstname = $user->getFirstname();
        // if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {
        $entityManager->remove($user);
        // $entityManager->persist($user);
        $entityManager->flush();
        // }

        return $this->json("$lastname $firstname a bien été supprimé.", Response::HTTP_ACCEPTED, [], []);
    }
}
