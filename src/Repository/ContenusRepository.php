<?php

namespace App\Repository;

use App\Entity\Contenus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contenus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contenus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contenus[]    findAll()
 * @method Contenus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContenusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contenus::class);
    }

    // /**
    //  * @return Contenus[] Returns an array of Contenus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contenus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
