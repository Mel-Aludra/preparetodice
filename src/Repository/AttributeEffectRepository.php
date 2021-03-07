<?php

namespace App\Repository;

use App\Entity\AttributeEffect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttributeEffect|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributeEffect|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributeEffect[]    findAll()
 * @method AttributeEffect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributeEffectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttributeEffect::class);
    }

    // /**
    //  * @return AttributeEffect[] Returns an array of AttributeEffect objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttributeEffect
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
