<?php

namespace App\Repository;

use App\Entity\CaracteristiquePerso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CaracteristiquePerso>
 *
 * @method CaracteristiquePerso|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracteristiquePerso|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracteristiquePerso[]    findAll()
 * @method CaracteristiquePerso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracteristiquePersoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaracteristiquePerso::class);
    }

//    /**
//     * @return CaracteristiquePerso[] Returns an array of CaracteristiquePerso objects
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

//    public function findOneBySomeField($value): ?CaracteristiquePerso
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
