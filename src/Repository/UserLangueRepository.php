<?php

namespace App\Repository;

use App\Entity\UserLangue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserLangue|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLangue|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLangue[]    findAll()
 * @method UserLangue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLangueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLangue::class);
    }

    // /**
    //  * @return UserLangue[] Returns an array of UserLangue objects
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
    public function findOneBySomeField($value): ?UserLangue
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