<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use App\Helper\ObjectHydrator;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;


class UserService extends AbstractController
{
    private $userRepository;
    private $em;

    /**
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }

    // ##########################################
    // ----------------- CREATE ----------------
    // ##########################################

    /**
     * @param UserDto $userDto
     * @return (User|int)[]|(null|string|int)[]
     */
    public function create(UserDto $userDto)
    {
        $userCreateAt = new \DateTimeImmutable();
        $userDto->setCreateAt($userCreateAt);

        $existingUser = $this->ifExist($userDto);
        if ($existingUser === null) {
            $user = ObjectHydrator::hydrate(
                $userDto,
                new User
            );
            $user->setUsers($user);

            $this->em->persist($user);
            $this->em->flush();

            return ["user" => $user->getId(), "code" => Response::HTTP_CREATED];
        }

        $title = "Not found";
        $message = "The user with email '" . $userDto->getEmail() . "' has existed since " . $userCreateAt->format('d/m/Y') . " at " . $userCreateAt->format('H:m:s');
        return ["user" => null, "title" => $title, "code" => 400, "message" => $message];
    }


    // ##########################################
    // ----------------- GET -------------------
    // ##########################################

    /**
     * ------------  read all ----------------
     * @return array
     */
    public function  findAll(): array /* User */
    {
        $user = $this->userRepository->findAll();
        if ($user === null) {
            $title = "Users not found";
            $message = "There are no users at all.";
            return ["user" => null, "title" => $title, "code" => Response::HTTP_NOT_FOUND, "message" => $message];
        }
        return ["user" => $user];
    }

    /**
     * ------------  read list ----------------
     *
     * @param mixed $id
     * @return array
     */
    public function findByUserField(int $id): array /* User */
    {
        $user = $this->userRepository->findByUserField($id);

        if ($user === []) {
            $title = "Users not found";
            $message = "You have not users";
            return ["user" => null, "title" => $title, "code" => Response::HTTP_NOT_FOUND, "message" => $message];
        }
        return ["user" => $user, "code" => Response::HTTP_ACCEPTED];
    }

    /**
     * ------------  read one ----------------
     *
     * @param mixed $id
     * @return array
     */
    public function findOne(int $id): array /* User */
    {
        $user[] = $this->userRepository->findOneByUser('id', $id);

        if ($user[0] === null) {
            $title = "Not found";
            $message = "The user doesn't exist";
            return ["user" => null, "title" => $title, "code" => Response::HTTP_NOT_FOUND, "message" => $message];
        }


        return ["user" => $user, "code" => Response::HTTP_ACCEPTED];
    }

    // ##########################################
    // ----------------- GET -------------------
    // ##########################################

    /**
     * @param mixed $id
     * @param mixed $userId
     * @return array
     */
    public function delete(int $id): array /* User */
    {
        $user = $this->userRepository->findOneByUser('id', $id);
        $title = "Delete is rejected";
        $codeResponse = Response::HTTP_NOT_FOUND;

        if ($user === null) {
            $message = "The user you want to delete does not exist";
        } elseif ($user === 404) {
            $message = "The entity you call does not exist";
        } else {

            $this->em->remove($user);
            $this->em->flush();
            $codeResponse = Response::HTTP_ACCEPTED;
            $title = "Delete a user";
            $message = "The user '" . $user->getName() .  "', creates the " . $user->getCreateAt()->format('d/m/Y') .  ", has been deleted";
        }
        return ["title" => $title, "code" => $codeResponse, 'message' => $message];
    }


    // ##########################################
    // ----------------- PRIVATE ---------------
    // ##########################################


    /**
     * @param UserDto $userDto
     * @return User
     */
    public function ifExist(UserDto $userDto)
    {
        return $this->userRepository->findExistingUser(
            $userDto->getEmail(),
            new \DateTimeImmutable()
        );
    }
}
