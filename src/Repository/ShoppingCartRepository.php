<?php

namespace App\Repository;

use App\Entity\ShoppingCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShoppingCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCart[]    findAll()
 * @method ShoppingCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCart::class);
    }

    // /**
    //  * @return ShoppingCart[] Returns an array of ShoppingCart objects
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
    public function findOneBySomeField($value): ?ShoppingCart
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findCart(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT products.name, products.price, products.id, COUNT(*) AS amount FROM shopping_cart 
        INNER JOIN profile ON profile.id = shopping_cart.profile_id 
        INNER JOIN shopping_cart_products ON shopping_cart_products.shopping_cart_id = shopping_cart.id 
        INNER JOIN products ON products.id = shopping_cart_products.products_id 
        WHERE profile.id = :id GROUP BY products.name';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetchAllAssociative();
    }

    public function removeCart(int $products, int $profile): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = 'DELETE shopping_cart FROM shopping_cart 
        INNER JOIN profile ON profile.id = shopping_cart.profile_id 
        INNER JOIN shopping_cart_products ON shopping_cart_products.shopping_cart_id = shopping_cart.id 
        INNER JOIN products ON products.id = shopping_cart_products.products_id 
        WHERE profile.id = :profil AND products.id = :products';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['profil' => $profile, 'products' => $products]);

        return $stmt->fetchAllAssociative();
    }
    public function buy($amount , $product): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE shopping_cart 
        INNER JOIN profile ON profile.id = shopping_cart.profile_id 
        INNER JOIN shopping_cart_products ON shopping_cart_products.shopping_cart_id = shopping_cart.id 
        INNER JOIN products ON products.id = shopping_cart_products.products_id 
        SET products.amount = products.amount - :amount 
        WHERE shopping_cart_products.products_id = :product';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['product' => $product, 'amount' => $amount]);
        
        return $stmt->fetchAllAssociative();
    }
}
