<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    /**
     * @param $price
     * @return Product[]
     */
    public function findAllGreaterThanPrice($price): array
    {
        // Va automatiquement faire un select sur la table product
        // "p" est un alias comme en SQL
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.price > :price')
            ->setParameter('price', $price) // bind value
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        // Debug de la requete    
        dump($queryBuilder->getSQL());

        /*

        if(???)
        {
            $qb->andWhere('..');
            $db->setParameter('price",$price);
        }

        */
        

        return $queryBuilder->getResult();
    }

    public function findOneGreaterThanPrice($price): Product
    {
        // On peut aussi retourner un seul produit par exemple
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $queryBuilder->getOneOrNullResult();
    }


    /*
     *Cette méthode doit retourner les 4 produits les plus chers de la bdd
     * Cette méthode devra être appellée sur notre page d'accueil afin d'afficher les 4 produits
     */
    public function findMoreExpensive(int $number = 4)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.price', 'DESC')
            ->setMaxResults($number)
            ->getQuery();       
        ;        

        return $queryBuilder->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
