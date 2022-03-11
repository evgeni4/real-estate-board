<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserPricingPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method UserPricingPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPricingPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPricingPlan[]    findAll()
 * @method UserPricingPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPricingPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPricingPlan::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserPricingPlan $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(UserPricingPlan $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return UserPricingPlan[] Returns an array of UserPricingPlan objects
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
    public function findOneBySomeField($value): ?UserPricingPlan
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function update(UserPricingPlan $userPlan): bool
    {
        try {
            $this->_em->persist($userPlan);
            $this->_em->flush();
            return true;
        }catch (OptimisticLockException $exception){
            return false;
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUserPlan(User $user)
    {
        $db = $this->createQueryBuilder('p');
        return $db
            ->where('p.user = :user')
            ->andWhere($db->expr()->isNotNull('p.validDate'))
            ->setParameter('user',$user)
            ->getQuery()->getOneOrNullResult();
        ;
    }
}
