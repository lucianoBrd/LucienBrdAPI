<?php

namespace App\Repository;

use App\Entity\Politic;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Politic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Politic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Politic[]    findAll()
 * @method Politic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Politic::class);
    }

    /**
     * @return Politic Returns a Politic objects
     */
    
    public function findOneArray()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_ARRAY)
        ;
    }

    /*
    public function findOneBySomeField($value): ?Politic
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
