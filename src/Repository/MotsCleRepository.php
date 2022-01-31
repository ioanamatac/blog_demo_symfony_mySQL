<?php

namespace App\Repository;

use App\Entity\MotsCle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotsCle|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotsCle|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotsCle[]    findAll()
 * @method MotsCle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotsCleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotsCle::class);
    }

    // /**
    //  * @return MotsCle[] Returns an array of MotsCle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MotsCle
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
