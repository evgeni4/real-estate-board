<?php

namespace App\Repository;

use App\Entity\PropertyRoomsWidget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyRoomsWidget|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyRoomsWidget|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyRoomsWidget[]    findAll()
 * @method PropertyRoomsWidget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRoomsWidgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyRoomsWidget::class);
    }

    // /**
    //  * @return RoomsWidget[] Returns an array of RoomsWidget objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoomsWidget
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
