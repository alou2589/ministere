<?php

namespace App\Repository;

use App\Entity\Agent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Postgresql;

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
    public function agents_structure($structure)
    {
        $query = $this->createQueryBuilder('a')
            ->select("COUNT(a) as agents")
            ->where("a.sous_structure IN( SELECT s_s.id FROM App\Entity\SousStructure s_s WHERE s_s.structure IN(SELECT s.id FROM App\Entity\Structure s WHERE s.id= :val ))")
            ->setParameter('val', $structure);
        
        return $query->getQuery()->getResult();
    }

    public function agentByYear()
    {
        $query = $this->createQueryBuilder('a')
            ->select("DATE_PART('year',a.date_prise_service) as date_record, COUNT(a) as nb_agents")
            ->groupBy('date_record')
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
