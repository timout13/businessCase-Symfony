<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();

        $user->setFirstname('Jean');
        $user->setLastname('Jean');
        $user->setEmail('jean@jean.jean');
        $user->setPassword('jean');
        $user->setGenre('male');
        $user->setBirthday('13/02/1999');
        $user->setNbStreet('7');
        $user->setAddressLine('esplanade de Russi');
        $user->setPostCode('63110');
        $user->setCity('Beaumont');

        $manager->persist($user);

        $manager->flush();
    }
}
