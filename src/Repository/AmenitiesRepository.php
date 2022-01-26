<?php

namespace App\Repository;

use App\Entity\Amenities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Amenities|null find($id, $lockMode = null, $lockVersion = null)
 * @method Amenities|null findOneBy(array $criteria, array $orderBy = null)
 * @method Amenities[]    findAll()
 * @method Amenities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmenitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amenities::class);
    }

    // /**
    //  * @return Amenitie[] Returns an array of Amenitie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Amenitie
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function insert(Amenities $amenities): bool
    {
        try {
            $this->_em->persist($amenities);
            $this->_em->flush();
            return true;
        }catch (OptimisticLockException $exception){
            return false;
        }
    }

    public function update(Amenities $amenities): bool
    {
        try {
            $this->_em->persist($amenities);
            $this->_em->flush();
            return true;
        }catch (OptimisticLockException $exception){
            return false;
        }
    }

    public function remove(Amenities $amenities): bool
    {
        try {
            $this->_em->remove($amenities);
            $this->_em->flush();
            return true;
        }catch (OptimisticLockException $exception){
            return false;
        }
    }
}
