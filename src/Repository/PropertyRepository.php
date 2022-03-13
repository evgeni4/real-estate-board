<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\Type;
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
            ->orwhere('p.price LIKE :price')
            ->setParameter("title", '%' . $str . '%')
            ->setParameter("price", '%' . $str . '%')
            ->getQuery()
            ->execute();
    }

    public function searchProperties(array $params)
    {
        if (array_key_exists('area', $params)) {
            $area = explode(';', $params['area']);
        }
        if (array_key_exists('price', $params)) {
            $prices = explode(';', $params['price']);
        }
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.published=:published');
        $qb->andWhere($qb->expr()->isNotNull('p.duration'));
        $qb->setParameter('published', true);
        if (!empty($params['keywords'])) {
            $qb->join('p.translations', 't');
            $qb->andWhere('t.title  LIKE :keyword');
            $qb->setParameter('keyword', $params['keywords']);
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
            $qb->join('p.propertyAmenities', 'am');
            $qb->andWhere(
                $qb->expr()->in('am.amenity', ':amenity'),
            );
            $qb->setParameter('amenity', $params['amenity'], Connection::PARAM_INT_ARRAY);
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

    public function wishlistProperties(array $params)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere(
            $qb->expr()->in('p.id', ':id'),
        );
        $qb->setParameter('id', $params, Connection::PARAM_INT_ARRAY);
        return $qb->getQuery()->getResult();
    }

    public function findByTypesProperties(Type $type)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.types = :type');
        $qb->andWhere($qb->expr()->isNotNull('p.duration'));
        $qb->setParameter('type', $type);
        return $qb->getQuery()->getResult();
    }

    public function findByCategoryProperties(Category $category)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.category = :category')
            ->setParameter('category', $category);
        return $qb->getQuery()->getResult();
    }

    public function featured(Property $property)
    {
        $count = $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.id != :id')
            ->andWhere('p.types = :type')
            ->andWhere('p.category = :category')
            ->setParameters(['id' => $property, 'type' => $property->getTypes(), 'category' => $property->getCategory()])
            ->getQuery()
            ->getSingleScalarResult();
        $db = $this->createQueryBuilder('p')
            ->where('p.id != :id')
            ->andWhere('p.types = :type')
            ->andWhere('p.category = :category')
            ->setFirstResult(rand(0, $count))
            ->setMaxResults(9)
            ->setParameters(['id' => $property, 'type' => $property->getTypes(), 'category' => $property->getCategory()]);

        return $db->getQuery()->getResult();
    }

    public function findAllByAgentListing(User $user)
    {
        $db = $this->createQueryBuilder('p');
        $db->where('p.agent = :agent')
            ->setParameters(['agent' => $user]);
        return $db->getQuery()->getResult();
    }

    public function getAllByCreateAtProperty($date, $user)
    {
        $db = $this->createQueryBuilder('p')
            ->select('count(p.agent)')
            ->where('p.agent = :agent')
            ->andWhere('p.createdAt BETWEEN :date AND :date2')
            ->setParameter('date', $date[0])
            ->setParameter('date2', $date[1])
            ->setParameter('agent', $user);
        return $db->getQuery()->getSingleScalarResult();
    }


    public function findAllByAgentListingActive(User $user)
    {
        $db = $this->createQueryBuilder('p');
        $db
            ->select('count(p.id) as count')
            ->where('p.agent = :agent')
            ->andWhere($db->expr()->isNotNull('p.duration'))
            ->groupBy('p.agent')
            ->setParameter('agent', $user);
        return $db->getQuery()->getOneOrNullResult();
    }

    public function findAllByAgentListingViews(?User $user)
    {
        $db = $this->createQueryBuilder('p');
        $db
            ->select('sum(p.viewed)')
            ->where('p.agent = :agent')
            ->groupBy('p.agent')
            ->setParameter('agent', $user);
        return $db->getQuery()->getSingleScalarResult();
    }

    public function propertiesPremium()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.published=:published');
        $qb->andWhere($qb->expr()->isNotNull('p.duration'));
        $qb->setParameter('published', true);
        return $qb->getQuery()->getResult();
    }

}
