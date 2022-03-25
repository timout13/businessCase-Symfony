<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function countByCat($idCat){
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->where('p.category = :idCat ')
            ->orWhere('cat.cat_parent = :idParent')
            ->setParameters(new ArrayCollection([new Parameter('idCat', $idCat), new Parameter('idParent', $idCat)]))
            ->join('p.category','cat')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByPagination($idCat, $currentPage, $nbDisplayed) {
        return $this->createQueryBuilder('p')
            ->where('p.category = :idCat ')
            ->orWhere('cat.cat_parent = :idParent')
            ->setParameters(new ArrayCollection([new Parameter('idCat', $idCat), new Parameter('idParent', $idCat)]))
            ->join('p.category','cat')
            ->setMaxResults($nbDisplayed)
            ->setFirstResult($currentPage*$nbDisplayed-$nbDisplayed)
            ->getQuery()
            ->getResult();
    }



    public function search($filter) {
        $query = $this->createQueryBuilder('p')->leftJoin('p.category', 'categ');


        if(!is_null($filter["searchBar"])){
            $query->where('p.name LIKE :name')
                ->orWhere('p.description LIKE :name')
                ->orWhere('categ.label LIKE :name')
                ->setParameter('name', '%'.$filter["searchBar"].'%');
        }

        if(!is_null($filter["category"])){
            $query->andWhere('categ = :categ')->setParameter('categ', $filter["category"]);
        }

        if(!empty($filter["nbStar"])){

            $query->andWhere('p.nbStar IN (:array)')->setParameter('array', $filter["nbStar"]);
        }

        if(!is_null($filter["minPrice"])){

            $query->andWhere('p.price > :minPrice')->setParameter('minPrice', $filter["minPrice"]);
        }

        if(!is_null($filter["maxPrice"])){

            $query->andWhere('p.price < :maxPrice')->setParameter('maxPrice', $filter['maxPrice']);
        }


        return $query->getQuery()->getResult();

    }

    // /**
    //  * @return Products[] Returns an array of Products objects
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
    public function findOneBySomeField($value): ?Products
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
