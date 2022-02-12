<?php

namespace App\Repository;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyAmenities|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyAmenities|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyAmenities[]    findAll()
 * @method PropertyAmenities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyAmenitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyAmenities::class);
    }


    // /**
    //  * @return PropertyAmenities[] Returns an array of PropertyAmenities objects
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
    public function findOneBySomeField($value): ?PropertyAmenities
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @throws NonUniqueResultException
     */
    public function findOne(Property $property, Amenities $amenities)
    {
        return $this->createQueryBuilder('pa')
            ->where('pa.property = :property')
            ->andWhere('pa.amenity = :amenity')
            ->setParameters(['property' => $property, 'amenity' => $amenities])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
