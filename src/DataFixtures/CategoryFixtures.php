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
    public const FELINNOURRITURE_REFERENCE='felinnourriture';
    public const POISSONNOURRITURE_REFERENCE='poissonnourriture';
    public const RONGEURNOURRITURE_REFERENCE='rongeurnourriture';
    public const VOLATILENOURRITURE_REFERENCE='volatilenourriture';
    public const CANIDENOURRITURE_REFERENCE='canidenourriture';
    public const FELINJOUET_REFERENCE='felinjouet';
    public const FELINCROQ_REFERENCE='felincroq';
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
        $this->addReference(self::FELINNOURRITURE_REFERENCE, $nourritureChat);

        $nourriturePoisson = new Category();
        $nourriturePoisson->setLabel('Nourriture pour Poisson');
        $nourriturePoisson->setCatParent($this->getReference(CategoryFixtures::POISSON_REFERENCE));
        $this->addReference(self::POISSONNOURRITURE_REFERENCE, $nourriturePoisson);

        $nourritureRongeur = new Category();
        $nourritureRongeur->setLabel('Nourriture pour Rongeur');
        $nourritureRongeur->setCatParent($this->getReference(CategoryFixtures::RONGEUR_REFERENCE));
        $this->addReference(self::RONGEURNOURRITURE_REFERENCE, $nourritureRongeur);


        $nourritureVolatile = new Category();
        $nourritureVolatile->setLabel('Nourriture pour Volatile');
        $nourritureVolatile->setCatParent($this->getReference(CategoryFixtures::VOLATILE_REFERENCE));
        $this->addReference(self::VOLATILENOURRITURE_REFERENCE, $nourritureVolatile);


        $nourritureCanide = new Category();
        $nourritureCanide->setLabel('Nourriture pour Canidé');
        $nourritureCanide->setCatParent($this->getReference(CategoryFixtures::CANIDE_REFERENCE));
        $this->addReference(self::CANIDENOURRITURE_REFERENCE, $nourritureCanide);


        $jouetChat = new Category();
        $jouetChat->setLabel('Jouets pour Chat');
        $jouetChat->setCatParent($this->getReference(CategoryFixtures::FELIN_REFERENCE));
        $this->addReference(self::FELINJOUET_REFERENCE, $jouetChat);

        $croquetteChat = new Category();
        $croquetteChat->setLabel('Croquette pour Chat');
        $croquetteChat->setCatParent($this->getReference(CategoryFixtures::FELINNOURRITURE_REFERENCE));
        $this->addReference(self::FELINCROQ_REFERENCE, $croquetteChat);


        $manager->persist($felin);
        $manager->persist($nourritureChat);
        $manager->persist($croquetteChat);
        $manager->persist($nourriturePoisson);
        $manager->persist($nourritureRongeur);
        $manager->persist($nourritureVolatile);
        $manager->persist($nourritureCanide);
        $manager->persist($jouetChat);
        $manager->persist($canide);
        $manager->persist($poisson);
        $manager->persist($rongeur);
        $manager->persist($volatile);
        $manager->flush();
    }
}
