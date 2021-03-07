<?php

namespace App\Repository;

use App\Entity\CharacterStatusEffect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacterStatusEffect|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterStatusEffect|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterStatusEffect[]    findAll()
 * @method CharacterStatusEffect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterStatusEffectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterStatusEffect::class);
    }

    // /**
    //  * @return CharacterStatusEffect[] Returns an array of CharacterStatusEffect objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CharacterStatusEffect
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
