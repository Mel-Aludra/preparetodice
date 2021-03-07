<?php

namespace App\Repository;

use App\Entity\LoreTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LoreTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoreTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoreTag[]    findAll()
 * @method LoreTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoreTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoreTag::class);
    }

    // /**
    //  * @return LoreTag[] Returns an array of LoreTag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LoreTag
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
