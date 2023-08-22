<?php

namespace App\Repository;

use App\Entity\CompetenceInflueCarac;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompetenceInflueCarac>
 *
 * @method CompetenceInflueCarac|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetenceInflueCarac|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetenceInflueCarac[]    findAll()
 * @method CompetenceInflueCarac[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceInflueCaracRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetenceInflueCarac::class);
    }

//    /**
//     * @return CompetenceInflueCarac[] Returns an array of CompetenceInflueCarac objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompetenceInflueCarac
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
