<?php

namespace App\Repository;

use App\Entity\InventoryGear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InventoryGear|null find($id, $lockMode = null, $lockVersion = null)
 * @method InventoryGear|null findOneBy(array $criteria, array $orderBy = null)
 * @method InventoryGear[]    findAll()
 * @method InventoryGear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryGearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryGear::class);
    }

    // /**
    //  * @return InventoryGear[] Returns an array of InventoryGear objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InventoryGear
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
