<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    /**
     * @return Stage[] Returns an array of Stage objects
     */
    public function findByDateAjout()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.dateAjout', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

        /**
     * @return Stage[] Returns an array of Stage objects
     */
    public function findByDateAjoutDql()
    {
       //Récupérer le gestionnaire d'entité
       $entityManager = $this->getEntityManager();

       //Construction de la requête
       $requete = $entityManager->createQuery(
           'SELECT s FROM App\Entity\Stage s
            ORDER BY s.dateAjout DESC'
       );

       //Execution de la requete et retour du résultat
       return $requete->execute();

    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
