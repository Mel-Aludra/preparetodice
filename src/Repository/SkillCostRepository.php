<?php

namespace App\Repository;

use App\Entity\SkillCost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillCost|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillCost|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillCost[]    findAll()
 * @method SkillCost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillCostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillCost::class);
    }

    // /**
    //  * @return SkillCost[] Returns an array of SkillCost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SkillCost
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
