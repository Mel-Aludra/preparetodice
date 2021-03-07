<?php

namespace App\Repository;

use App\Entity\InventoryConsumable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InventoryConsumable|null find($id, $lockMode = null, $lockVersion = null)
 * @method InventoryConsumable|null findOneBy(array $criteria, array $orderBy = null)
 * @method InventoryConsumable[]    findAll()
 * @method InventoryConsumable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryConsumableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryConsumable::class);
    }

    // /**
    //  * @return InventoryConsumable[] Returns an array of InventoryConsumable objects
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
    public function findOneBySomeField($value): ?InventoryConsumable
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
