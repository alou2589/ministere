<?php

namespace App\Repository;

use App\Entity\AffectationVehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AffectationVehicule>
 */
class AffectationVehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AffectationVehicule::class);
    }
    public function findWithAgentStructure():array
    {
        return $this->createQueryBuilder('a')
            ->select('a','sta','aff','ag', 'ss','s')
            ->leftJoin('a.affectation','aff')
            ->leftJoin('aff.sous_structure','ss')
            ->leftJoin('ss.structure','s')
            ->leftJoin('aff.statut_agent','sta')
            ->leftJoin('sta.agent','ag')
            ->getQuery()
            ->getResult()
            ;
    }

    //    /**
    //     * @return AffectationVehicule[] Returns an array of AffectationVehicule objects
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

    //    public function findOneBySomeField($value): ?AffectationVehicule
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
