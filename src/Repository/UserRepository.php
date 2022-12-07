<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
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

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function RechercheUser($username,$userpwd){
        //$em=$this->getEntityManager();
        //$query=$em->createQuery('select u fromApp\Entity\User u where u.username=:username and u.userpwd=:userpwd');
        //return $query->getResult();
        return $this->createQueryBuilder('u')->where('u.username  =:username')
<<<<<<< HEAD
<<<<<<< HEAD
        ->andwhere('u.userpwd =:userpwd')->setParameter('username',$username)
        ->setParameter('userpwd',$userpwd)->getQuery()->getResult();
    }
=======
=======
>>>>>>> main
<<<<<<< HEAD
        ->andwhere('u.userpwd =:userpwd')->setParameter('username',$username)
        ->setParameter('userpwd',$userpwd)->getQuery()->getResult();
<<<<<<< HEAD
    }
=======
>>>>>>> 078c388824bb1ea755dd5d30634ea302c0539f84
=======
<<<<<<< HEAD
            ->andwhere('u.userpwd =:userpwd')->setParameter('username',$username)
            ->setParameter('userpwd',$userpwd)->getQuery()->getResult();
>>>>>>> ae22cea8f9cdcf653139a274fbefdb0dd0d0e7c5
    }

=======
        ->andwhere('u.userpwd =:userpwd')->setParameter('username',$username)
        ->setParameter('userpwd',$userpwd)->getQuery()->getResult();
    }
    public function forgetpwd($username,$email){
        return $this->createQueryBuilder('u')->where('u.username  =:username')
        ->andwhere('u.email =:email')->setParameter('username',$username)
        ->setParameter('email',$email)->getQuery()->getResult();
   
    }
    public function updatepwd($username,$email,$pwd){
        $this->update('u')->set('u.userpwd',$pwd)
        ->where('u.username =:username')->andWhere('u.email =:email')
        ->setParameter('username',$username)->setParameter('email',$email)->getQuery()->execute();
    }
    public function findUser($username){
        return $this->createQueryBuilder('u')->where('u.username LIKE :username')
        ->setParameter('username','%' .$username. '%')->getQuery()->getResult();
    }
    public function trier(){
        return $this->createQueryBuilder('u')->orderBy('u.role')->getQuery()->getResult();
    }
    public function countuser(){
        return $this->createQueryBuilder('u')->select('count(u.iduser)')->groupBy('u.role')
        ->getQuery()->getResult();
    }
    public function countuser1($role){
        return $this->createQueryBuilder('u')->select('count(u.iduser)')->where('u.role =:role')
        ->setParameter('role',$role)->getQuery()->getResult();
    }
>>>>>>> main
<<<<<<< HEAD
>>>>>>> 078c388824bb1ea755dd5d30634ea302c0539f84
=======
>>>>>>> refs/remotes/origin/main
>>>>>>> main
//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
