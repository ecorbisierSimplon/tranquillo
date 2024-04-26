<?php

namespace App\Repository;

use App\Entity\TpaRoles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TpaRoles>
 *
 * @method TpaRoles|null find($id, $lockMode = null, $lockVersion = null)
 * @method TpaRoles|null findOneBy(array $criteria, array $orderBy = null)
 * @method TpaRoles[]    findAll()
 * @method TpaRoles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TpaRolesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TpaRoles::class);
    }

    //    /**
    //     * @return TpaRoles[] Returns an array of TpaRoles objects
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

    //    public function findOneBySomeField($value): ?TpaRoles
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
