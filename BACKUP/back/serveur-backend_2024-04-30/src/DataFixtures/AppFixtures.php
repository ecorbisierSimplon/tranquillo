<?php
// src\DataFixtures\UsersFixtures.php

namespace App\DataFixtures;

use App\Entity\TpaSubtasks;
use App\Entity\TpaTasks;
use App\Entity\TpaUsers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/** @package App\DataFixtures */
class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /* La méthode `public function load(ObjectManager ): void` dans la classe `AppFixtures` est
    une méthode requise par l'interface `Fixture` dans les appareils Doctrine. Cette méthode est
    chargée de remplir la base de données avec des données factices pendant le processus de
    chargement des appareils de données. */
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
            /* Cette ligne de code est chargée de hacher le mot de passe de l'utilisateur avant de le
            définir dans l'entité ``. Voici un aperçu de ce qui se passe : */
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $fixUser['password']));
            $user->setUserCreateAt(new \DateTimeImmutable());
            $manager->persist($user);
            $manager->flush();

            $listUsers[] = $user;
        }

        // require_once($cheminData . "/fixturesTasks.php");
        // foreach ($fixturesTasks  as $fixTask) {
        //     $task = new TpaTasks;
        //     // Accéder aux éléments de la tâche
        //     $userEmail = $fixTask['usersEmail'];

        //     // Recherche de l'utilisateur par son email dans la liste des utilisateurs
        //     $filteredUsers = array_filter($listUsers, function ($user) use ($userEmail) {
        //         return $user->getEmail() === $userEmail;
        //     });

        //     // Accéder aux éléments de la tâche
        //     $user = reset($filteredUsers); // Récupérer le premier utilisateur correspondant
        //     // $userId = $user->getId(); // Récupérer l'ID de l'utilisateur


        //     // Utiliser l'entité utilisateur dans la tâche
        //     $task->setUsers($user);
        //     $task->setTaskName($fixTask['taskTitle']);
        //     $task->setTaskDescription($fixTask['taskDescription']);
        //     $task->setTaskReminder($fixTask['taskReminder']);

        //     $task->setTaskCreateAt(new \DateTimeImmutable());

        //     $taskStartAtString = $fixTask['taskStartAt'];
        //     $taskStartAt = new \DateTimeImmutable($taskStartAtString);
        //     $task->setTaskStartAt($taskStartAt);

        //     $taskEndAtString = $fixTask['taskEndAt'];
        //     $taskEndAt = new \DateTimeImmutable($taskEndAtString);
        //     $task->setTaskEndAt($taskEndAt);

        //     $manager->persist($task);
        //     $manager->flush();

        //     $listTasks[] = $task;
        // }


        // require_once($cheminData . "/fixturesSubtasks.php");
        // foreach ($fixturesSubtasks  as $fixSubtask) {
        //     $subtask = new TpaSubtasks();
        //     // Accéder aux éléments de la sous-tâche
        //     $userEmail = $fixSubtask['usersEmail'];
        //     $taskTitle = $fixSubtask['tasksTitle'];

        //     // Recherche de l'utilisateur par son email dans la liste des utilisateurs
        //     $user = array_filter($listUsers, function ($user) use ($userEmail) {
        //         return $user->getEmail() === $userEmail;
        //     });
        //     // Récupérer le premier utilisateur correspondant
        //     $user = reset($user);

        //     // Recherche de la tâche par son titre et l'id de l'utilisateur
        //     $filteredTasks = array_filter($listTasks, function ($task) use ($taskTitle, $user) {
        //         return ($task->getTaskName() === $taskTitle && $task->getUsers()->getId() === $user->getId());
        //     });

        //     // Récupérer la première tâche correspondante
        //     $task = reset($filteredTasks);

        //     // Associer la tâche à la sous-tâche
        //     $subtask->setTasks($task);
        //     $subtask->setSubtaskName($fixSubtask['subtaskName']);
        //     $subtask->setSubtaskOrder($fixSubtask['subtaskOrder']);
        //     $subtask->setSubtaskIsFinished($fixSubtask['subtaskIsFinished']);

        //     $subtask->setSubtaskCreateAt(new \DateTimeImmutable());

        //     $manager->persist($subtask);
        //     $manager->flush();

        //     $listSubtasks[] = $subtask;
        // }

        /* `->flush();` dans le contexte de Doctrine ORM est utilisé pour synchroniser les
        modifications avec la base de données. Lorsque vous persistez ou supprimez des entités dans
        Doctrine, les modifications sont conservées en mémoire jusqu'à ce que vous appeliez
        `->flush();`. Cette méthode exécute ensuite les requêtes SQL nécessaires pour
        insérer, mettre à jour ou supprimer les entités de la base de données. Il valide
        essentiellement les modifications apportées au cours de la transaction en cours dans la base
        de données. */
        $manager->flush();

        echo "Fixture terminé.";
    }
}
