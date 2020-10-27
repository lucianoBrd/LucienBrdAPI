<?php

namespace App\Repository;

use App\Entity\Cv;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Cv|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cv|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cv[]    findAll()
 * @method Cv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cv::class);
    }

    /**
     * @return Cv Returns a Cv objects
     */
    
    public function findOneArray()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_ARRAY)
        ;
    }

    /*
    public function findOneBySomeField($value): ?Cv
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
