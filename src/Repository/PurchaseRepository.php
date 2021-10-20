<?php

namespace App\Repository;

use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    // /**
    //  * @return Purchase[] Returns an array of Purchase objects
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
    public function findOneBySomeField($value): ?Purchase
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findhistory(string $email): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT products.name, products.price, products.image FROM purchase 
        INNER JOIN user ON purchase.user_id = user.id 
        INNER JOIN products ON purchase.product_id = products.id 
        WHERE user.email = :email';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetchAllAssociative();
    }
    public function findsellhistory(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT products.name, products.price, products.image FROM `purchase` 
        INNER JOIN products ON purchase.product_id = products.id 
        WHERE products.seller_id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetchAllAssociative();
    }
}
