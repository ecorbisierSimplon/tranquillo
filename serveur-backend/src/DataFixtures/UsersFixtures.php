<?php
// src\DataFixtures\UsersFixtures.php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\TpaSubtasks;
use App\Entity\TpaTasks;
use App\Entity\TpaUsers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Récupérer le chemin absolu du dossier courant
        // Chemin du dossier courant
        $cheminCourant = __DIR__;
        // Diviser le chemin en segments en utilisant le délimiteur "/"
        $segments = explode("/", $cheminCourant);
        $folderBack = $_ENV['FOLDER_BACK'];
        $folderData = $_ENV['FOLDER_DATA'];
        // Trouver l'index du segment contenant "tranquillo"
        $indexfolderBack = array_search($folderBack, $segments);
        // Reconstituer le chemin absolu du dossier tranquillo en utilisant les segments précédents
        $cheminBack = implode("/", array_slice($segments, 0, $indexfolderBack + 1));
        $cheminData = dirname($cheminBack) . "/" . $folderData . "/sql_test";



        require_once($cheminData . "/fixturesUsers.php");
        $user = new TpaUsers();
        // Création d'un user admin
        $user->setRoles(["ROLE_WEBMASTER"]);
        $user->setEmail("eric@corbisier.fr");
        $user->setLastname("CORBISIER");
        $user->setFirstname("Eric");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "PassWord:1234@"));
        $user->setUserCreateAt(new \DateTimeImmutable());
        $manager->persist($user);
        $listUsers[] = $user;

        // Création d'un user "normal"
        foreach ($fixturesUsers as $fixUser) {
            $user = new TpaUsers();
            // Accéder aux éléments de l'utilisateur
            $user->setRoles([$fixUser['role']]);
            $user->setEmail($fixUser['email']);
            $user->setLastname($fixUser['lastname']);
            $user->setFirstname($fixUser['firstname']);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $fixUser['password'])); // Assumant que le mot de passe est stocké dans la colonne 'mot_de_passe'
            $user->setUserCreateAt(new \DateTimeImmutable());
            $manager->persist($user);
            $manager->flush();

            $listUsers[] = $user;
        }

        require_once($cheminData . "/fixturesTasks.php");
        foreach ($fixturesTasks  as $fixTask) {
            $task = new TpaTasks;
            // Accéder aux éléments de la tâche
            $userEmail = $fixTask['usersEmail'];

            // Recherche de l'utilisateur par son email dans la liste des utilisateurs
            $filteredUsers = array_filter($listUsers, function ($user) use ($userEmail) {
                return $user->getEmail() === $userEmail;
            });

            // Accéder aux éléments de la tâche
            $user = reset($filteredUsers); // Récupérer le premier utilisateur correspondant
            // $userId = $user->getId(); // Récupérer l'ID de l'utilisateur

            // Utiliser l'entité utilisateur dans la tâche
            $task->setUsers($user);
            $task->setTaskName($fixTask['taskTitle']);
            $task->setTaskDescription($fixTask['taskDescription']);
            $task->setTaskReminder($fixTask['taskReminder']);

            $task->setTaskCreateAt(new \DateTimeImmutable());

            $taskStartAtString = $fixTask['taskStartAt'];
            $taskStartAt = new \DateTimeImmutable($taskStartAtString);
            $task->setTaskStartAt($taskStartAt);

            $taskEndAtString = $fixTask['taskEndAt'];
            $taskEndAt = new \DateTimeImmutable($taskEndAtString);
            $task->setTaskEndAt($taskEndAt);

            $manager->persist($task);
            $manager->flush();

            $listTasks[] = $task;
        }



        require_once($cheminData . "/fixturesSubtasks.php");
        foreach ($fixturesSubtasks  as $fixSubtask) {
            $subtask = new TpaSubtasks;
            // Accéder aux éléments de la tâche
            $userEmail = $fixSubtask['usersEmail'];
            $taskTitle = $fixSubtask['tasksTitle'];

            // Recherche de l'utilisateur par son email dans la liste des utilisateurs
            $user = array_filter($listUsers, function ($user) use ($userEmail) {
                return $user->getEmail() === $userEmail;
            });
            // Accéder aux éléments de la tâche
            $user = reset($filteredUsers); // Récupérer le premier utilisateur correspondant
            // $userId = $user->getId(); // Récupérer l'ID de l'utilisateur

            // Recherche de la tache par son titre (name) dans la liste des tasks et par l'id de l'utilisateur
            $filteredTask = array_filter($listTasks, function ($task) use ($taskTitle, $user) {
                return ($task->getTaskName() === $taskTitle && $task->getUsers() === $user);
            });

            // Accéder aux éléments de la tâche
            // Accéder aux éléments de la tâche
            $task = reset($filteredTask); // Récupérer le premier utilisateur correspondant
            // $taskId = $task->getId(); // Récupérer l'ID de l'utilisateur
            // Associer l'id de la tache à la sous-tâche
            $subtask->setTasks($task);
            $subtask->setSubtaskName($fixSubtask['subtaskTitle']);
            $subtask->setSubtaskOrder($fixSubtask['subtaskOrder']);
            $subtask->setSubtaskIsFinished($fixSubtask['subtaskIsFinished']);


            $manager->persist($subtask);
            $manager->flush();

            $listSubtasks[] = $subtask;
        }

        $manager->flush();
    }
}
