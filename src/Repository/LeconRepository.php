<?php

namespace App\Repository;

use App\Entity\Lecon;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lecon>
 *
 * @method Lecon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lecon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lecon[]    findAll()
 * @method Lecon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeconRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lecon::class);
    }

    /**
     * @return array Returns an array of Lecon objects
     */
    public function findByEleve(User $eleve): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere(':val MEMBER OF l.eleves')
            ->setParameter('val', $eleve)
            ->orderBy('l.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Lecon
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
