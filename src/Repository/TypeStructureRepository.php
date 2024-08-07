<?php

namespace App\Repository;

use App\Entity\TypeStructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeStructure>
 *
 * @method TypeStructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeStructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeStructure[]    findAll()
 * @method TypeStructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeStructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeStructure::class);
    }

    public function save(TypeStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithStructures():array
    {
        return $this->createQueryBuilder('t')
            ->select('t','s')
            ->leftJoin('t.structures','s')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return TypeStructure[] Returns an array of TypeStructure objects
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

//    public function findOneBySomeField($value): ?TypeStructure
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
