<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
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
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function insert(Property $property): bool
    {
        try {
            $this->_em->persist($property);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $exception) {
            return false;
        }
    }

    public function update(Property $property): bool
    {
        try {
            $this->_em->persist($property);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $exception) {
            return false;
        }
    }

    public function findByAgentListing(User $user, int $start, int $limit)
    {
        $bd = $this->createQueryBuilder('p')
            ->where('p.agent = :user')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->setParameters([
                'user' => $user
            ]);
        return $bd->getQuery()->getResult();
    }

    public function getSimilarProperties(Property $property)
    {
        $db = $this->createQueryBuilder('p')
            ->where('p.id != :id')
            ->andWhere('p.types = :type')
            ->andWhere('p.category = :category')
            ->orderBy('p.createdAt','ASC')
            ->setMaxResults(9)
            ->setParameters(['id'=>$property->getId(),'type' => $property->getTypes(), 'category' => $property->getCategory()]);
        return $db->getQuery()->getResult();
    }
}
