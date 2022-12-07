<?php

namespace App\Repository;

use App\Entity\Devoir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Devoir>
 *
 * @method Devoir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devoir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devoir[]    findAll()
 * @method Devoir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevoirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devoir::class);
    }

    public function save(Devoir $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Devoir $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
//
//   query resultat select DISTINCTROW d.namedevoir , q.numquestion, r.idreponse ,r.note from devoir d inner join question q inner join reponse r
//on d.iddevoir=q.iddevoir and q.idquestion=r.idquestion
//where d.iddevoir=3 and r.idetudiant=2;
//

    public function resultat(int $idd,int$ide):array
    {
        $em=$this->getEntityManager();
        $query=$em->createQueryBuilder();
        $query->select('r.note')
            ->distinct(true)
            ->from('App\Entity\devoir','d')
            ->innerJoin('App\Entity\question','q','WITH','q.iddevoir=d.iddevoir')
            ->innerJoin('App\Entity\Reponse','r','WITH','r.idquestion=q.idquestion')
            ->where('d.iddevoir=:inputdevoir')
            ->andWhere('r.idetudiant=:inputetudiant')
            ->setParameter('inputdevoir',$idd)
            ->setParameter('inputetudiant',$ide)
        ;

        return $query->getQuery()->getArrayResult() ;
    }

    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT d
                FROM App\Entity\Devoir d
                WHERE d.namedevoir LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }
    public function countcategorydevoir():array{
        $em=$this->getEntityManager();
        $query=$em->createQueryBuilder();
        $query->select( 'd.category as categ','COUNT(d.category) as counting')
            ->from('App\Entity\devoir','d')
            ->groupBy('d.category');
        return $query->getQuery()->getArrayResult() ;
    }



//    /**
//     * @return Devoir[] Returns an array of Devoir objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Devoir
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
