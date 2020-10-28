<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function findAllArray()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.date', 'DESC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * @return Project[] Returns an array of 3 random Project objects
     */
    public function findRandomArray($ids)
    {
        $query = $this->createQueryBuilder('p');

        /* Get 3 random id */
        shuffle($ids);
        $ids = array_slice($ids, 0, 3);

        /* Add where close */
        $i = 0;
        $where = '';
        foreach ($ids as $id) {
            if($i > 0) {
                $where .= ' OR ';
            }
            $where .= 'p.id = :id' . $id;
            $i++;
        }
        $query->andWhere($where);

        /* Set parameters */
        foreach ($ids as $id) {
            $query->setParameter('id' . $id, $id);
        }

        return $query->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * @return Integer[] Returns an array of id Integer
     */
    public function findAllId()
    {
        $arrayIds = $this->createQueryBuilder('p')
            ->select('p.id')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        $ids = null;
        foreach ($arrayIds as $id) {
            $ids[] = $id['id'];
        }

        return $ids;
    }
}
