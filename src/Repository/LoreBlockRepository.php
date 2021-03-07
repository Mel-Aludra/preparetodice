<?php

namespace App\Repository;

use App\Entity\LoreBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LoreBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoreBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoreBlock[]    findAll()
 * @method LoreBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoreBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoreBlock::class);
    }

    // /**
    //  * @return LoreBlock[] Returns an array of LoreBlock objects
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
    public function findOneBySomeField($value): ?LoreBlock
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
