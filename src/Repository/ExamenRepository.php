<?php

namespace App\Repository;

use App\Entity\Examen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Examen>
 */
class ExamenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Examen::class);
    }  

    /**
     * @return Examen[] Returns an array of Examen objects, Buscar los exámenes por usuario autenticado y ordenados por materia y fecha.
     */
    public function findByUser($user): array
    {
    return $this->createQueryBuilder('e')
        ->where('e.usuario = :user')
        ->setParameter('user', $user)
        ->orderBy('e.materia', 'ASC') 
        ->addOrderBy('e.fecha', 'DESC') 
        ->getQuery()
        ->getResult();
    }
  

//    public function findOneBySomeField($value): ?Examen
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
