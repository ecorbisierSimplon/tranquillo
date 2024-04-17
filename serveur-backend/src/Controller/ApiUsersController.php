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
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
class ApiUsersController extends AbstractController
{
    #[Route('/', name: 'app_api_users_index', methods: ['GET'])]
    public function index(TpaUsersRepository $tpaUsersRepository): JsonResponse
    {
        return $this->json($tpaUsersRepository->findAll(),200,[],[
            'groups' => ['users.index']
        ]);
        // return $this->render('api_users/index.html.twig', [
        //     'tpa_users' => $tpaUsersRepository->findAll(),
        // ]);
    }

    #[Route('/new', name: 'app_api_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tpaUser = new TpaUsers();
        $form = $this->createForm(TpaUsersType::class, $tpaUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tpaUser);
            $entityManager->flush();

            return $this->redirectToRoute('app_api_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api_users/new.html.twig', [
            'tpa_user' => $tpaUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_api_users_show', methods: ['GET'])]
    public function show(TpaUsers $tpaUser): JsonResponse
    {
        return $this->json($tpaUser,201,[],[
            'groups' => ['users.index', 'users.show']
        ]);
        // return $this->render('api_users/show.html.twig', [
        //     'tpa_user' => $tpaUser,
        // ]);
    }

    #[Route('/{id}/edit', name: 'app_api_users_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_api_users_delete', methods: ['POST'])]
    public function delete(Request $request, TpaUsers $tpaUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tpaUser->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($tpaUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_api_users_index', [], Response::HTTP_SEE_OTHER);
    }
}