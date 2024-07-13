<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Materiel>
 *
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }

    public function save(Materiel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAllWithTypeAndMarque():array
    {
        return $this->createQueryBuilder('m')
            ->select('m','t','mq')
            ->leftJoin('m.type_matos','t')
            ->leftJoin('m.marque_matos','mq')
            ->getQuery()
            ->getResult()
            ;
    }

    public function remove(Materiel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function matosByYear($nom_type_matos=[])
    {
        $query = $this->createQueryBuilder('m')
            ->select("SUBSTRING(m.date_reception, 1,4) AS date_record, COUNT(m) AS nb_matos")
            ->where('m.type_matos IN (SELECT t.id FROM App\Entity\TypeMateriel t WHERE t.nom_type_matos IN (:nom_type_matos))')
            ->setParameter('nom_type_matos',$nom_type_matos)
            ->groupBy('date_record')
        ;
        return $query->getQuery()->getResult();
    }
    




//    /**
//     * @return Materiel[] Returns an array of Materiel objects
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

//    public function findOneBySomeField($value): ?Materiel
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
