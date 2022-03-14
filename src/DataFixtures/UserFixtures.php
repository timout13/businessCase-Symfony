<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $admin = new User();

        $admin->setFirstname('Jean');
        $admin->setLastname('Jean');
        $admin->setEmail('jean@jean.jean');
        $admin->setPassword($this->hasher->hashPassword($admin,'jean'));
        $admin->setGenre('male');
        $admin->setBirthday('13/02/1999');
        $admin->setNbStreet('7');
        $admin->setAddressLine('esplanade de Russi');
        $admin->setPostCode('63110');
        $admin->setCity('Beaumont');

        $manager->persist($admin);

        $manager->flush();
    }
}
