<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Education;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Education|null find($id, $lockMode = null, $lockVersion = null)
 * @method Education|null findOneBy(array $criteria, array $orderBy = null)
 * @method Education[]    findAll()
 * @method Education[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EducationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Education::class);
    }

    /**
     * @return Education[] Returns an array of Education objects
     */
    
    public function findAllArray()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date', 'DESC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Education
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
