<?php

namespace App\Repository;

use App\Entity\Affectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Affectation>
 *
 * @method Affectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affectation[]    findAll()
 * @method Affectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affectation::class);
    }


    public function affectationByStructureGenre(string $nom_structure,string $genre)
    {
        $query = $this->createQueryBuilder('a')
            ->select("a")
            ->where("a.statut_agent IN(SELECT st.id FROM App\Entity\StatutAgent st WHERE st.agent IN(SELECT ag.id FROM App\Entity\Agent ag WHERE ag.genre= :genre))")
            ->andWhere("a.sous_structure IN( SELECT s_s.id FROM App\Entity\SousStructure s_s WHERE s_s.structure IN(SELECT s.id FROM App\Entity\Structure s WHERE s.nom_structure= :val ))")
            ->setParameter("val", $nom_structure)
            ->setParameter("genre",$genre)
        ;

        return $query->getQuery()->getResult();
    }
    public function affectation_structure($structure)
    {
        $query = $this->createQueryBuilder('a')
            ->select("COUNT(a) as agents")
            ->where("a.sous_structure IN( SELECT s_s.id FROM App\Entity\SousStructure s_s WHERE s_s.structure IN(SELECT s.id FROM App\Entity\Structure s WHERE s.id= :val ))")
            ->setParameter('val', $structure)
        ;

        return $query->getQuery()->getResult();
    }


    public function affectationBySousStructureGenre(string $genre, string $nom_sous_structure)
    {
        $query = $this->createQueryBuilder('a')
            ->where("a.statut_agent IN(SELECT s.id FROM App\Entity\StatutAgent s WHERE s.agent IN(SELECT ag.id FROM App\Entity\Agent ag WHERE ag.genre= :genre))")
            ->andWhere("a.sous_structure IN(SELECT ss.id FROM App\Entity\SousStructure ss WHERE ss.nom_sous_structure= :nom_sous_structure)")
            ->setParameter("genre",$genre)
            ->setParameter("nom_sous_structure",$nom_sous_structure)
        ;
        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Affectation[] Returns an array of Affectation objects
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

//    public function findOneBySomeField($value): ?Affectation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
