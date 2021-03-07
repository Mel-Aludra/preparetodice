<?php

namespace App\Repository;

use App\Entity\InventoryWeapon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InventoryWeapon|null find($id, $lockMode = null, $lockVersion = null)
 * @method InventoryWeapon|null findOneBy(array $criteria, array $orderBy = null)
 * @method InventoryWeapon[]    findAll()
 * @method InventoryWeapon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryWeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryWeapon::class);
    }

    // /**
    //  * @return InventoryWeapon[] Returns an array of InventoryWeapon objects
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
    public function findOneBySomeField($value): ?InventoryWeapon
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
