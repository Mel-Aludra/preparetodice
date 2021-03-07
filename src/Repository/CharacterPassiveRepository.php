<?php

namespace App\Repository;

use App\Entity\CharacterPassive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacterPassive|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterPassive|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterPassive[]    findAll()
 * @method CharacterPassive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterPassiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterPassive::class);
    }

    // /**
    //  * @return CharacterPassive[] Returns an array of CharacterPassive objects
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
    public function findOneBySomeField($value): ?CharacterPassive
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
