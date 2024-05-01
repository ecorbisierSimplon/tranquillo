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


    public function findExistingTask($taskName, $taskCreateAt)
    {
        return $this->createQueryBuilder('t')
            ->where('t.name = :name')
            ->andWhere('t.createAt = :createAt')
            ->setParameter('name', $taskName)
            ->setParameter('createAt', $taskCreateAt)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByTask($by, $value)
    {

        if (in_array($by, $this->entitySearch)) {
            $task = $this->find($value);
            return $task;
        }

        $codeResponse = Response::HTTP_NOT_FOUND;
        return new JsonResponse([], $codeResponse);;
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
