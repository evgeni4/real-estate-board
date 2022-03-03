<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\Reviews;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reviews|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reviews|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reviews[]    findAll()
 * @method Reviews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reviews::class);
    }

    // /**
    //  * @return Reviews[] Returns an array of Reviews objects
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
    public function findOneBySomeField($value): ?Reviews
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function insert(Reviews $reviews): bool
    {
        try {
            $this->_em->persist($reviews);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $exception) {
            return false;
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function reviewsFromUser(User $user)

    {
        $qd = $this->createQueryBuilder('r')
            ->addSelect(' 
            COUNT(r.rating) as count,
            ROUND(AVG( r.rating),2)  as rating
            ')
            ->where('r.user = :user')
            ->groupBy('r.user')
            ->setParameter('user', $user);
        return $qd->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function reviewsFromProperty(Property $property)

    {
        $qd = $this->createQueryBuilder('r')
            ->addSelect(' 
            COUNT(r.rating) as count,
            ROUND(AVG( r.rating),2)  as rating
            ')
            ->where('r.property = :property')
            ->groupBy('r.property')
            ->setParameter('property', $property);
        return $qd->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getLastReviewsFromProperty(User $user, Property $property)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.property = :property')
            ->andWhere('r.user = :user')
            ->orderBy('r.id','DESC')
            ->setMaxResults(1)
            ->setParameters(['property' => $property, 'user' => $user]);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
