<?php

namespace App\Repository;

use App\Entity\UserGameCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserGameCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGameCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGameCharacter[]    findAll()
 * @method UserGameCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGameCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGameCharacter::class);
    }

    // /**
    //  * @return UserGameCharacter[] Returns an array of UserGameCharacter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserGameCharacter
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
