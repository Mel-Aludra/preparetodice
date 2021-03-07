<?php

namespace App\Repository;

use App\Entity\EquippedGear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EquippedGear|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquippedGear|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquippedGear[]    findAll()
 * @method EquippedGear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquippedGearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquippedGear::class);
    }

    // /**
    //  * @return EquippedGear[] Returns an array of EquippedGear objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EquippedGear
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
