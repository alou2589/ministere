<?php

namespace App\Repository;

use App\Entity\Attribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql;

/**
 * @extends ServiceEntityRepository<Attribution>
 *
 * @method Attribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attribution[]    findAll()
 * @method Attribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attribution::class);
    }

    public function save(Attribution $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Attribution $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function attribByYear()
    {
        $query = $this->createQueryBuilder('a')
            ->select("COUNT(a) AS nb_attribution, (CASE WHEN YEAR(CURRENT_DATE())-YEAR(a.date_attribution)<3 THEN 'Moins de 3ans' WHEN YEAR(CURRENT_DATE())-YEAR(a.date_attribution)>=3 AND YEAR(CURRENT_DATE())-YEAR(a.date_attribution)<5 THEN 'Entre 3 et 5ans' WHEN YEAR(CURRENT_DATE())-YEAR(a.date_attribution)>5 THEN 'Plus de 5ans' ELSE 'Error' END) AS duree_utilisation")
            ->groupBy('duree_utilisation')
        ;
        return $query->getQuery()->getResult();
    }
    
    
    public function matosAttrib($typeMatos){
        $query = $this->createQueryBuilder('a')
            ->where("a.matos IN(SELECT m.id FROM App\Entity\Materiel m WHERE m.type_matos IN (SELECT t.id FROM App\Entity\TypeMateriel t WHERE t.nom_type_matos= :typeMatos))")
            ->setParameter('typeMatos', $typeMatos)
            ;
        return $query->getQuery()->getResult();
    }
//    /**
//     * @return Attribution[] Returns an array of Attribution objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Attribution
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
