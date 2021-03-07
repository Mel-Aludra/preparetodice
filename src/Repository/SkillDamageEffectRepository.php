<?php

namespace App\Repository;

use App\Entity\SkillDamageEffect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillDamageEffect|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillDamageEffect|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillDamageEffect[]    findAll()
 * @method SkillDamageEffect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillDamageEffectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillDamageEffect::class);
    }

    // /**
    //  * @return SkillDamageEffect[] Returns an array of SkillDamageEffect objects
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
    public function findOneBySomeField($value): ?SkillDamageEffect
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
