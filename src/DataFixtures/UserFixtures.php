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
        $admin->setRoles(['ROLE_ADMIN']);

        $client = new User();

        $client->setFirstname('Marc');
        $client->setLastname('Marc');
        $client->setEmail('marc@marc.marc');
        $client->setPassword($this->hasher->hashPassword($admin,'marc'));
        $client->setGenre('male');
        $client->setBirthday('13/02/2000');
        $client->setNbStreet('14');
        $client->setAddressLine('esplanade de Kosovi');
        $client->setPostCode('63110');
        $client->setCity('Bellomont');
        $client->setRoles(['ROLE_USER']);
        $manager->persist($client);
        $manager->persist($admin);

        $manager->flush();
    }
}
