<?php

namespace App\Repository;

use App\Entity\MarqueMatos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MarqueMatos>
 *
 * @method MarqueMatos|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarqueMatos|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarqueMatos[]    findAll()
 * @method MarqueMatos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueMatosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarqueMatos::class);
    }

    public function save(MarqueMatos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MarqueMatos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MarqueMatos[] Returns an array of MarqueMatos objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MarqueMatos
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
