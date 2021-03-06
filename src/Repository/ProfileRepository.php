<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    // /**
    //  * @return Profile[] Returns an array of Profile objects
    //  */
    
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('p.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /*
    public function findOneBySomeField($value): ?Profile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findprofile(string $email): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT profile.id, profile.avatar, profile.name, profile.surname, user.email,profile.user_id        
        FROM profile INNER JOIN user ON 
        profile.user_id = user.id WHERE user.email = :email';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetchAllAssociative();
    }
    public function findProfileUser(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT profile.id 
        FROM profile INNER JOIN user ON 
        profile.user_id = user.id WHERE user.id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetchAllAssociative();
    }
    
}
