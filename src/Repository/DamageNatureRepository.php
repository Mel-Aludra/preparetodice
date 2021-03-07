<?php

namespace App\Repository;

use App\Entity\DamageNature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DamageNature|null find($id, $lockMode = null, $lockVersion = null)
 * @method DamageNature|null findOneBy(array $criteria, array $orderBy = null)
 * @method DamageNature[]    findAll()
 * @method DamageNature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DamageNatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DamageNature::class);
    }

    // /**
    //  * @return DamageNature[] Returns an array of DamageNature objects
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
    public function findOneBySomeField($value): ?DamageNature
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
