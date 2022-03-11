<?php

namespace App\Repository;

use App\Entity\PricingPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PricingPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method PricingPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method PricingPlan[]    findAll()
 * @method PricingPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PricingPlan::class);
    }

    // /**
    //  * @return PricingPlanController[] Returns an array of PricingPlanController objects
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
    public function findOneBySomeField($value): ?PricingPlanController
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function add(PricingPlan $plan): bool
    {
        try {
            $this->_em->persist($plan);
            $this->_em->flush();
            return true;
        }catch (OptimisticLockException $e){
            return false;
        }
    }

    public function edit(PricingPlan $plan): bool
    {
        try {
            $this->_em->persist($plan);
            $this->_em->flush();
            return true;
        }catch (OptimisticLockException $e){
            return false;
        }
    }

    public function delete(PricingPlan $plan): bool
    {
        try {
            $this->_em->remove($plan);
            $this->_em->flush();
            return true;
        }catch (OptimisticLockException $e){
            return false;
        }
    }
}
