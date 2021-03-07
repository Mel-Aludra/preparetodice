<?php

namespace App\Repository;

use App\Entity\Passive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Passive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Passive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Passive[]    findAll()
 * @method Passive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Passive::class);
    }

    // /**
    //  * @return Passive[] Returns an array of Passive objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Passive
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
