<?php

namespace App\Repository;

use App\Entity\TypeAbsence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeAbsence>
 *
 * @method TypeAbsence|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeAbsence|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeAbsence[]    findAll()
 * @method TypeAbsence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeAbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeAbsence::class);
    }

//    /**
//     * @return TypeAbsence[] Returns an array of TypeAbsence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeAbsence
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
