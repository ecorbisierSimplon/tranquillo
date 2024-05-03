<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



class UserService extends AbstractController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }

    public function  findAll(): JsonResponse
    {
        return $this->json($this->userRepository->findAll(), 200, [], [
            'groups' => ['users: read']
        ]);
    }

    public function findOne($id): JsonResponse
    {
        $user = $this->userRepository->findOneByUser('id', $id);

        if ($user === null) {
            $title = "Lecture impossible";
            $message = "L'utilisateur que vous voulez lire n'existe pas";
            $codeResponse = Response::HTTP_NOT_FOUND;
            return new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
        }
        return $this->json($user, 201, [], [
            'groups' => ['users: read']
        ]);
    }


    public function create(UserDto $userDto)
    {
        $userCreateAt = new \DateTimeImmutable();
        $userDto->setCreateAt($userCreateAt);
        $existingUser = $this->userRepository->findOneByUser('email', $userDto->getEmail());

        if ($existingUser === null) {
            $user = new User;
            $user->setLastname($userDto->getLastname());
            $user->setFirstname($userDto->getFirstname());
            $user->setEmail($userDto->getEmail());
            $user->setPassword($userDto->getPassword());
            $user->setCreateAt($userDto->getCreateAt());

            $this->em->persist($user);
            $this->em->flush();
            return $this->json($user, Response::HTTP_CREATED, [], [
                'groups' => ['users: create']
            ]);
        }
        $title = "Création refusée";
        $message = "L'utilisateur avec l'email '" . $userDto->getEmail() . "' existe depuis le " . $userCreateAt->format('d/m/Y') . " à " . $userCreateAt->format('H:m:s');
        $codeResponse = Response::HTTP_BAD_REQUEST;
        return new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
    }



    public function delete(int $id = null): JsonResponse
    {
        // if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {

        $title = "Suppression refusée";
        $codeResponse = Response::HTTP_NOT_FOUND;

        $user = NULL;
        if ($id !== null) {
            $user = $this->userRepository->findOneByUser('id', $id);
        }

        if ($user === null) {
            $message = "L'utilisateur que vous voulez supprimer n'existe pas";
        } elseif ($user === 404) {
            $message = "L'entité que vous appelez n'existe pas";
        } else {

            $this->em->remove($user);
            $this->em->flush();
            $codeResponse = Response::HTTP_ACCEPTED;
            $title = "Suppression d'un utilisateur";
            $message = "L'utilisateur ayant pour email '" . $user->getEmail() .  "', créé le " . $user->getCreateAt()->format('d/m/Y') .  ", a été supprimé de la base de données";
        }

        $response = new JsonResponse(["title" => $title, "status" => $codeResponse, 'detail' => $message], $codeResponse);
        return $response;
    }

    // public function ifExist(UserDto $userDto)
    // {
    //     $userName = $userDto->getName();
    //     $userCreateAt = new \DateTimeImmutable();

    //     $existingUser = $this->userRepository->findExistingUser($userName, $userCreateAt);

    //     return $existingUser;
    // }
}
