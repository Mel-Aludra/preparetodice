<?php

namespace App\Repository;

use App\Entity\EquipmentSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EquipmentSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipmentSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipmentSlot[]    findAll()
 * @method EquipmentSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentSlot::class);
    }

    // /**
    //  * @return EquipmentSlot[] Returns an array of EquipmentSlot objects
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
    public function findOneBySomeField($value): ?EquipmentSlot
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
