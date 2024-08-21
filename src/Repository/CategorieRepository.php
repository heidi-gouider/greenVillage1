<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * Récupère uniquement les catégories parentes.
     */
    public function findParentCategories()
    {
        return $this->createQueryBuilder('c')
            ->where('c.parent_categorie IS NULL')
            ->getQuery()
            ->getResult();
    }
    // public function getSomeCategories($libelleCategorie)
    // {
    //     $entityManager = $this->getEntityManager(); //on instancie l'entity manager
    
    //     $query = $entityManager->createQuery( //on crée la requête 
    //         'SELECT a
    //         FROM App\Entity\Categorie a
    //         WHERE a.libelleCategorie  like :libelle_categorie'
    //     )->setParameter('libelle_categorie', '%'.$libelleCategorie.'%');
    
    //     // retourne un tableau d'objets de type Categorie
    //     return $query->getResult();
    
    // } 
//    /**
//     * @return Categorie[] Returns an array of Categorie objects
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

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
