<?php

namespace App\Repository;

use App\Entity\BattleLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BattleLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BattleLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BattleLog[]    findAll()
 * @method BattleLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BattleLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BattleLog::class);
    }

    // /**
    //  * @return BattleLog[] Returns an array of BattleLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BattleLog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
