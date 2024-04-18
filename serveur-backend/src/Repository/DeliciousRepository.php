<?php

namespace App\Repository;

use App\Entity\Delicious;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Delicious>
 *
 * @method Delicious|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delicious|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delicious[]    findAll()
 * @method Delicious[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliciousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delicious::class);
    }

    //    /**
    //     * @return Delicious[] Returns an array of Delicious objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Delicious
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
