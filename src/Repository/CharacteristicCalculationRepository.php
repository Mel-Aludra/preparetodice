<?php

namespace App\Repository;

use App\Entity\CharacteristicCalculation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacteristicCalculation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacteristicCalculation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacteristicCalculation[]    findAll()
 * @method CharacteristicCalculation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacteristicCalculationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacteristicCalculation::class);
    }

    // /**
    //  * @return CharacteristicCalculation[] Returns an array of CharacteristicCalculation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CharacteristicCalculation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
