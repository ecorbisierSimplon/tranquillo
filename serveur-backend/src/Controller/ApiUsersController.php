<?php

namespace App\Controller;

use App\Entity\TpaUsers;
use App\Form\TpaUsersType;
use App\Repository\TpaUsersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/users')]
class ApiUsersController extends AbstractController
{
    #[Route('/', name: 'app_api_users_index', methods: ['GET'])]
    public function index(TpaUsersRepository $tpaUsersRepository, SerializerInterface $serializer): JsonResponse
    {
        $usersList = $tpaUsersRepository->findAll();

        $jsonUsersList = $serializer->serialize($usersList, 'json', ['groups' => 'users.show']);
        return new JsonResponse($jsonUsersList, Response::HTTP_OK, [], true);
    }

    /**
     * Cette fonction PHP crée un nouvel objet TpaUsers en désérialisant les données JSON d'une requête
     * POST.
     * 
     * @param Request request Le paramètre `Request` dans la méthode `new` représente la requête HTTP
     * entrante. Il contient toutes les informations sur la requête, telles que les en-têtes, les
     * paramètres et le contenu.
     * @param SerializerInterface serializer Le paramètre `` dans l'extrait de code fait
     * référence à une instance d'une classe qui implémente SerializerInterface de Symfony. Cette
     * interface fournit des méthodes de sérialisation et de désérialisation des données, vous
     * permettant de convertir des objets dans différents formats tels que JSON, XML ou YAML.
     */
    #[Route('/' | '', name: 'app_api_users_new', methods: ['POST'])]
    public function new(
        Request $request,
        #[MapRequestPayload(
            serializationContext: [
                'groups' => ['users.create']
            ]
        )]
        TpaUsers $user,
        EntityManagerInterface $em
    ) {

        $user->setUserCreateAt(new \DateTimeImmutable());
        $em->persist($user);
        $em->flush();
        return $this->json($user, 200, [], [
            'groups' => ['users.index', 'users.show']
        ]);
    }


    #[Route('/{id}', name: 'app_api_users_show', methods: ['GET'])]
    public function show(TpaUsers $tpaUser): Response
    {
        return $this->render('api_users/show.html.twig', [
            'tpa_user' => $tpaUser,
        ]);
    }

    #[Route('/{id}', name: 'app_api_users_edit', methods: ['PUT'])]
    public function edit(Request $request, TpaUsers $tpaUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TpaUsersType::class, $tpaUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_api_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api_users/edit.html.twig', [
            'tpa_user' => $tpaUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_api_users_delete', methods: ['DELETE'])]
    public function delete(Request $request, TpaUsers $tpaUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($tpaUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_api_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
