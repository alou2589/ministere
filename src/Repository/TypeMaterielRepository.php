<?php

namespace App\Repository;

use App\Entity\TypeMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeMateriel>
 *
 * @method TypeMateriel|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMateriel|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMateriel[]    findAll()
 * @method TypeMateriel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeMateriel::class);
    }

    public function save(TypeMateriel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeMateriel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }  
    
    public function laptops()
    {
        $query = $this->createQueryBuilder('t')
            ->where("t.nom_type_matos='Ordinateur Portable' ")
        ;
        return $query->getQuery()->getOneOrNullResult();
    }
    public function desktops()
    {
        $query = $this->createQueryBuilder('t')
            ->where("t.nom_type_matos ='Ordinateur Fixe' ")
        ;
        return $query->getQuery()->getOneOrNullResult();
    }
    public function aios()
    {
        $query = $this->createQueryBuilder('t')
            ->where("t.nom_type_matos ='All In One' ")
        ;
        return $query->getQuery()->getOneOrNullResult();
    }
    public function printerColors()
    {
        $query = $this->createQueryBuilder('t')
            ->where("t.nom_type_matos ='Imprimante Couleur' ")
        ;
        return $query->getQuery()->getOneOrNullResult();
    }
    public function pinterNBs()
    {
        $query = $this->createQueryBuilder('t')
            ->where("t.nom_type_matos ='Imprimante Noir et Blanc' ")
        ;
        return $query->getQuery()->getOneOrNullResult();
    }
    public function photocopieuses()
    {
        $query = $this->createQueryBuilder('t')
            ->where("t.nom_type_matos ='Photocopieuse Multifonction' ")
        ;
        return $query->getQuery()->getOneOrNullResult();
    }

//    /**
//     * @return TypeMateriel[] Returns an array of TypeMateriel objects
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

//    public function findOneBySomeField($value): ?TypeMateriel
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
