<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private $passwordHasher;

         public function __construct(UserPasswordHasherInterface $passwordHasher)
         {
             $this->passwordHasher = $passwordHasher;
         }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        // $product = new Product();
        // $manager->persist($product);
        $user->setPassword($this->passwordHasher->hashPassword(
                         $user,
                         'the_new_password'
                     ));
        $manager->flush();
    }
}
