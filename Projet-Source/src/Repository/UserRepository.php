<?php

namespace App\Repository;

use App\Entity\Agences;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

     /**
      * @return User[] Returns an array of User objects
        */
    public function findByExampleField()
    {

        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("u.id,u.email")
            ->from(User::class, 'u')
            ->leftJoin(Agences::class,"a","WITH","a.Utilisateur=u.id")
            ->where("a.Utilisateur IS NULL")
            ->orderBy('u.id', 'DESC');
        $query = $query->getQuery();
        $result=$query->getResult();
        return $result;
    }
    /**
     * @return User[] Returns an array of Pays objects
     */
    public function findByRole($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.role = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

}
