<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    /**
     * @return Blog[] Returns an array of Blog objects
     */
    public function findAllArray($local)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.local = :local')
            ->setParameter('local', $local)
            ->leftJoin('b.tags', 'tag')
            ->addSelect('tag')
            ->orderBy('b.date', 'DESC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * @return Blog[] Returns an array of Blog objects
     */
    public function findLatestArray($local)
    {
        $blogs = $this->createQueryBuilder('b')
            ->andWhere('b.local = :local')
            ->setParameter('local', $local)
            ->leftJoin('b.tags', 'tag')
            ->addSelect('tag')
            ->orderBy('b.date', 'DESC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;

        if (count($blogs) > 3) {
            return array_slice($blogs, 0, 3);
        }
        return $blogs;
    }

    /**
     * @return Blog[] Returns an array of Blog objects
     */
    public function findByTagArray($local, $tag)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.local = :local')
            ->leftJoin('b.tags', 'tag')
            ->addSelect('tag')
            ->andWhere('tag.slug = :slug')
            ->setParameter('local', $local)
            ->setParameter('slug', $tag)
            ->orderBy('b.date', 'DESC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * @return Blog Returns a Blog object
     */
    public function findOneBySlugArray($local, $slug)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.local = :local')
            ->andWhere('b.slug = :slug')
            ->setParameter('local', $local)
            ->setParameter('slug', $slug)
            ->leftJoin('b.tags', 'tag')
            ->addSelect('tag')
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_ARRAY)
        ;
    }
}
