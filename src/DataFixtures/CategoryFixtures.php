<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const FELIN_REFERENCE='felin';
    public const CANIDE_REFERENCE='canide';
    public const VOLATILE_REFERENCE='volatile';
    public const RONGEUR_REFERENCE='rongeur';
    public const POISSON_REFERENCE='poisson';
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $felin = new Category();
        $felin->setLabel('Félin');
        $this->addReference(self::FELIN_REFERENCE, $felin);

        $canide = new Category();
        $canide->setLabel('Canidé');
        $this->addReference(self::CANIDE_REFERENCE, $canide);

        $volatile = new Category();
        $volatile->setLabel('Volatile');
        $this->addReference(self::VOLATILE_REFERENCE, $volatile);

        $rongeur = new Category();
        $rongeur->setLabel('Rongeur');
        $this->addReference(self::RONGEUR_REFERENCE, $rongeur);

        $poisson = new Category();
        $poisson->setLabel('Poisson');
        $this->addReference(self::POISSON_REFERENCE, $poisson);

        $nourritureChat = new Category();
        $nourritureChat->setLabel('Nourriture pour Chat');
        $nourritureChat->setCatParent($this->getReference(CategoryFixtures::FELIN_REFERENCE));

        $jouetChat = new Category();
        $jouetChat->setLabel('Jouets pour Chat');
        $jouetChat->setCatParent($this->getReference(CategoryFixtures::POISSON_REFERENCE));

        $manager->persist($felin);
        $manager->persist($nourritureChat);
        $manager->persist($jouetChat);
        $manager->persist($canide);
        $manager->persist($poisson);
        $manager->persist($rongeur);
        $manager->persist($volatile);
        $manager->flush();
    }
}
