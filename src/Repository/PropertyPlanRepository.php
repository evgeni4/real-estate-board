<?php

namespace App\Repository;

use App\Entity\PropertyPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyPlan[]    findAll()
 * @method PropertyPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyPlan::class);
    }

    // /**
    //  * @return PropertyPlan[] Returns an array of PropertyPlan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PropertyPlan
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
