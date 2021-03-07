<?php

namespace App\Repository;

use App\Entity\CharacterAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacterAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterAttribute[]    findAll()
 * @method CharacterAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterAttribute::class);
    }

    // /**
    //  * @return CharacterAttribute[] Returns an array of CharacterAttribute objects
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
    public function findOneBySomeField($value): ?CharacterAttribute
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
