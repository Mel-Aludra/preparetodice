<?php

namespace App\Repository;

use App\Entity\SkillHealEffect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillHealEffect|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillHealEffect|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillHealEffect[]    findAll()
 * @method SkillHealEffect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillHealEffectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillHealEffect::class);
    }

    // /**
    //  * @return SkillHealEffect[] Returns an array of SkillHealEffect objects
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
    public function findOneBySomeField($value): ?SkillHealEffect
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
