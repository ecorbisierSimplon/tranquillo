<?php

namespace App\Repository;

use App\Entity\TpaSubtasks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TpaSubtasks>
 *
 * @method TpaSubtasks|null find($id, $lockMode = null, $lockVersion = null)
 * @method TpaSubtasks|null findOneBy(array $criteria, array $orderBy = null)
 * @method TpaSubtasks[]    findAll()
 * @method TpaSubtasks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TpaSubtasksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TpaSubtasks::class);
    }

    //    /**
    //     * @return TpaSubtasks[] Returns an array of TpaSubtasks objects
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

    //    public function findOneBySomeField($value): ?TpaSubtasks
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
