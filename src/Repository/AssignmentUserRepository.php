<?php

namespace App\Repository;

use App\Entity\AssignmentUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssignmentUser>
 *
 * @method AssignmentUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssignmentUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssignmentUser[]    findAll()
 * @method AssignmentUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignmentUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssignmentUser::class);
    }

    //    /**
    //     * @return AssignmentUser[] Returns an array of AssignmentUser objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AssignmentUser
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
