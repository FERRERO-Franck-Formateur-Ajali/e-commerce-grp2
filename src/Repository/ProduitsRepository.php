<?php

namespace App\Repository;

use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

    /**
     * Recherche les produits en fonction de la recherche
     */
    public function search(string $mots = NULL)
    {
        $query = $this->createQueryBuilder('p');
        $query->where('p.actif = 1');
        
       
        if($mots !== null){

             /*     
            $query->andWhere('MATCH_AGAINST(p.titre, p.description) AGAINST(:mots boolean)>0')
                ->setParameter('mots', $mots);
              */
            $query->andWhere('p.titre LIKE :mots OR p.description LIKE :mots OR p.couleur LIKE :mots OR p.taille LIKE :mots');

            $query->setParameter('mots', '%'.$mots.'%'); 
        }
        
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Produits[] Returns an array of Produits objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produits
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
