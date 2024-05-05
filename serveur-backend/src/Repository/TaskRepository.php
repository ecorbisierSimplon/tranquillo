<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    private $entitySearch;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
        $this->entitySearch = array('id', 'name');
    }


    public function findExistingTask($taskName, $taskCreateAt): ?Task
    {
        $return = $this->createQueryBuilder('t')
            ->where('t.name = :name')
            ->andWhere('t.createAt = :createAt')
            ->setParameter('name', $taskName)
            ->setParameter('createAt', $taskCreateAt)
            ->getQuery()
            ->getOneOrNullResult();

        return ($return === []) ? null : $return;
    }

    public function findOneByTask($by, $value): ?Task
    {

        if (in_array($by, $this->entitySearch)) {
            $task = $this->findOneBy([$by => $value]);
            return $task;
        }
        return Response::HTTP_NOT_FOUND;;
    }

    /**
     * @return Task[] Returns an array of Task objects
     */
    public function findByUserField($value): ?array
    {
        $return = $this->createQueryBuilder('t')
            ->andWhere('t.usersId = :user')
            ->setParameter('user', $value)
            ->orderBy('t.createAt', 'ASC')
            ->getQuery()
            ->getResult();

        return ($return === []) ? null : $return;
    }

    //    /**
    //     * @return Task[] Returns an array of Task objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Task
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
