<?php

namespace App\Repository;

use App\Entity\Agent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Postgresql;
use DoctrineExtensions\Query\Mysql;

/**
 * @extends ServiceEntityRepository<Agent>
 *
 * @method Agent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agent[]    findAll()
 * @method Agent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agent::class);
    }

    public function save(Agent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Agent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function agentByYear()
    {
        $query = $this->createQueryBuilder('a')
            ->select(" COUNT(a) AS nb_agents,(CASE WHEN (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))<30 THEN 'Moins de 30ans' WHEN (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))>=30 AND (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))<40 THEN 'Entre 30 et 40ans' WHEN (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))>=40 AND (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))<50 THEN 'Entre 40 et 50ans' WHEN (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))>=50 AND (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))<60 THEN 'Entre 50 et 60ans' WHEN (YEAR(CURRENT_DATE())-YEAR(a.date_naissance))>60 THEN 'Plus de 60ans' ELSE 'Error' END) AS tranche_age ")
            ->groupBy('tranche_age')
        ;
        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Agent[] Returns an array of Agent objects
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

//    public function findOneBySomeField($value): ?Agent
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
