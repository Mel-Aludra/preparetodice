<?php

namespace App\Repository;

use App\Entity\DamageOverTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DamageOverTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method DamageOverTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method DamageOverTime[]    findAll()
 * @method DamageOverTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DamageOverTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DamageOverTime::class);
    }

    // /**
    //  * @return DamageOverTime[] Returns an array of DamageOverTime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DamageOverTime
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
