<?php

namespace App\Repository;

use App\Entity\Agences;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Agences|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agences|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agences[]    findAll()
 * @method Agences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agences::class);
    }

     /**
      * @return Agences[] Returns an array of Agences objects
      */

    public function findByExampleField()
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select("u.id")
            ->from(User::class, 'u')
            ->innerJoin(Agences::class,"a","WITH","a.Utilisateur=u.id")
            ->orderBy('u.id', 'DESC');
        $query = $query->getQuery();
        $result=$query->getResult();
        return $result;
    }



    public function findOneByUser($value): ?Agences
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.Utilisateur = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


}