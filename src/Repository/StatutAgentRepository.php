<?php

namespace App\Repository;

use App\Entity\StatutAgent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql;

/**
 * @extends ServiceEntityRepository<StatutAgent>
 *
 * @method StatutAgent|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutAgent|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutAgent[]    findAll()
 * @method StatutAgent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutAgentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutAgent::class);
    }

    public function save(StatutAgent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatutAgent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function statutAgentByYear()
    {
        $query = $this->createQueryBuilder('s')
            ->select("SUBSTRING(s.date_debut_ministere, 1,4) AS date_record, COUNT(s) AS nb_agents")
            ->groupBy('date_record')
        ;
        return $query->getQuery()->getResult();
    }
//    /**
//     * @return StatutAgent[] Returns an array of StatutAgent objects
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

//    public function findOneBySomeField($value): ?StatutAgent
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
