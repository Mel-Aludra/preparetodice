<?php

namespace App\Repository;

use App\Entity\SkillStatusEffect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillStatusEffect|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillStatusEffect|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillStatusEffect[]    findAll()
 * @method SkillStatusEffect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillStatusEffectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillStatusEffect::class);
    }

    // /**
    //  * @return SkillStatusEffect[] Returns an array of SkillStatusEffect objects
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
    public function findOneBySomeField($value): ?SkillStatusEffect
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
