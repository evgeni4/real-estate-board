<?php

namespace App\Repository;

use App\Entity\PropertyRoomsWidgetAmenities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyRoomsWidgetAmenities|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyRoomsWidgetAmenities|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyRoomsWidgetAmenities[]    findAll()
 * @method PropertyRoomsWidgetAmenities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRoomsWidgetAmenitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyRoomsWidgetAmenities::class);
    }

    // /**
    //  * @return PropertyRoomsWidgetAmenities[] Returns an array of PropertyRoomsWidgetAmenities objects
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
    public function findOneBySomeField($value): ?PropertyRoomsWidgetAmenities
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
