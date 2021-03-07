<?php

namespace App\Repository;

use App\Entity\PotencyAugmentator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PotencyAugmentator|null find($id, $lockMode = null, $lockVersion = null)
 * @method PotencyAugmentator|null findOneBy(array $criteria, array $orderBy = null)
 * @method PotencyAugmentator[]    findAll()
 * @method PotencyAugmentator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PotencyAugmentatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PotencyAugmentator::class);
    }

    // /**
    //  * @return PotencyAugmentator[] Returns an array of PotencyAugmentator objects
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
    public function findOneBySomeField($value): ?PotencyAugmentator
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
