<?php

namespace App\Repository;

use App\Entity\Draw;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Draw>
 *
 * @method Draw|null find($id, $lockMode = null, $lockVersion = null)
 * @method Draw|null findOneBy(array $criteria, array $orderBy = null)
 * @method Draw[]    findAll()
 * @method Draw[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrawRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Draw::class);
    }

    public function getAllQuery($query = null): Query
    {
        $qb = $this->createQueryBuilder('draw');
        if ($query) {
            $queries = explode('-', $query);
            foreach ($queries as $key => $str) {
                $qb->andWhere('draw.winComboAsc like :query_'.$key)
                    ->setParameter('query_'.$key, '%'.$str.'%')
                ;
            }
        }

        return $qb->orderBy('draw.nbDraw', 'DESC')->getQuery();
    }

    public function save(Draw $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Draw $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Draw[] Returns an array of Draw objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Draw
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
