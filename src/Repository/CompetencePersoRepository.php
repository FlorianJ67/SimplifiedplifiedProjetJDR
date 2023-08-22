<?php

namespace App\Repository;

use App\Entity\CompetencePerso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompetencePerso>
 *
 * @method CompetencePerso|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetencePerso|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetencePerso[]    findAll()
 * @method CompetencePerso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetencePersoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetencePerso::class);
    }

//    /**
//     * @return CompetencePerso[] Returns an array of CompetencePerso objects
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

//    public function findOneBySomeField($value): ?CompetencePerso
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
