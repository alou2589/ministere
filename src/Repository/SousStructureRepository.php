<?php

namespace App\Repository;

use App\Entity\SousStructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SousStructure>
 *
 * @method SousStructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousStructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousStructure[]    findAll()
 * @method SousStructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousStructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousStructure::class);
    }

    public function save(SousStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SousStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function ss_structure($structure)
    {
        $query = $this->createQueryBuilder('ss')
            ->select("COUNT(ss) as sous_structures")
            ->where("ss.structure IN( SELECT s.id FROM App\Entity\Structure s WHERE s.id= :val )")
            ->setParameter('val', $structure);
        
        return $query->getQuery()->getResult();
    }

//    /**
//     * @return SousStructure[] Returns an array of SousStructure objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SousStructure
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
