<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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
            ->orderBy('p.createdAt', 'ASC')
            ->setMaxResults(9)
            ->setParameters(['id' => $property->getId(), 'type' => $property->getTypes(), 'category' => $property->getCategory()]);
        return $db->getQuery()->getResult();
    }
    public function searchKeywords($str)
    {

        return $this->createQueryBuilder('p')
            ->addSelect('pTrans')
            ->join('p.translations', 'pTrans')
            ->where('pTrans.title LIKE :title')
            ->setParameter("title", '%' . $str . '%')
            ->getQuery()
            ->execute();
    }
    public function searchProperties(array $params)
    {
         // dd($params);
        $prices = explode(';', $params['price']);
        $area = explode(';', $params['area']);
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.published=:published');
        $qb->join('p.propertyAmenities',   'am');
        $qb->setParameter('published', true);
        if (!empty($params['keyword'])) {
            $qb->join('p.translations', 't');
            $qb->andWhere('t.title  LIKE :type');
            $qb->setParameter('keyword', (int)$params['keyword']);
        }
        if (!empty($params['type'])) {
            $qb->andWhere('p.types  =:type');
            $qb->setParameter('type', (int)$params['type']);
        }
        if (!empty($params['category'])) {
            $qb->andWhere('p.category = :category');
            $qb->setParameter('category', (int)$params['category']);
        }
        if (!empty($params['price'])) {
            $qb->andWhere('p.price BETWEEN :min AND :max');
            $qb->setParameter("min", (int)$prices[0]);
            $qb->setParameter('max', (int)$prices[1]);
        }
        if (!empty($params['bedrooms'])) {
            $qb->andWhere('p.bedrooms = :bedrooms');
            $qb->setParameter('bedrooms', (int)$params['bedrooms']);
        }
        if (!empty($params['bathrooms'])) {
            $qb->andWhere('p.bathrooms = :bathrooms');
            $qb->setParameter('bathrooms', (int)$params['bathrooms']);
        }
        if (!empty($params['referenceNumber'])) {
            $qb->andWhere('p.referenceNumber = :referenceNumber');
            $qb->setParameter('referenceNumber', (int)$params['referenceNumber']);
        }
        if (!empty($params['floors'])) {
            $qb->andWhere('p.floors = :floors');
            $qb->setParameter('floors', (int)$params['floors']);
        }
        if (!empty($params['area'])) {
            $qb->andWhere('p.area BETWEEN :areaMin AND :areaMax');
            $qb->setParameter("areaMin", (int)$area[0]);
            $qb->setParameter('areaMax', (int)$area[1]);
        }
        if (array_key_exists('amenity', $params)) {

            $qb->andWhere(
                $qb->expr()->in('am.amenity', ':amenity'),
            );
            $qb->setParameter('amenity', $params['amenity'],Connection::PARAM_INT_ARRAY);
        }
        $qb->groupBy('p.id');
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function minMaxNumber()
    {
        $db = $this->createQueryBuilder('p')
            ->select(
                [
                    'Min(p.price) as min',
                    'Max(p.price) as max',
                    'Max(p.bedrooms) as bedrooms',
                    'Max(p.bathrooms) as bathrooms',
                    'Max(p.floors) as floors',
                    'Min(p.area) as areaMin',
                    'Max(p.area) as areaMax',
                ]);
        return $db->getQuery()->getOneOrNullResult();
    }
}
