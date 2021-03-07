<?php

namespace App\Repository;

use App\Entity\ResourceAlteration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResourceAlteration|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceAlteration|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceAlteration[]    findAll()
 * @method ResourceAlteration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceAlterationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceAlteration::class);
    }

    // /**
    //  * @return ResourceAlteration[] Returns an array of ResourceAlteration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResourceAlteration
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
