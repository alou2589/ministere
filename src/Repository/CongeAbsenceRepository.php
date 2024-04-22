<?php

namespace App\Repository;

use App\Entity\CongeAbsence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CongeAbsence>
 *
 * @method CongeAbsence|null find($id, $lockMode = null, $lockVersion = null)
 * @method CongeAbsence|null findOneBy(array $criteria, array $orderBy = null)
 * @method CongeAbsence[]    findAll()
 * @method CongeAbsence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CongeAbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CongeAbsence::class);
    }

//    /**
//     * @return CongeAbsence[] Returns an array of CongeAbsence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CongeAbsence
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
