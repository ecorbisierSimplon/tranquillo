<?php

namespace App\Repository;

use App\Entity\TpaTasks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TpaTasks>
 *
 * @method TpaTasks|null find($id, $lockMode = null, $lockVersion = null)
 * @method TpaTasks|null findOneBy(array $criteria, array $orderBy = null)
 * @method TpaTasks[]    findAll()
 * @method TpaTasks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TpaTasksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TpaTasks::class);
    }

    //    /**
    //     * @return TpaTasks[] Returns an array of TpaTasks objects
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

    //    public function findOneBySomeField($value): ?TpaTasks
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
