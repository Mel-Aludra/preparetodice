<?php

namespace App\Repository;

use App\Entity\Consumable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Consumable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consumable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consumable[]    findAll()
 * @method Consumable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsumableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consumable::class);
    }

    // /**
    //  * @return Consumable[] Returns an array of Consumable objects
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
    public function findOneBySomeField($value): ?Consumable
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
