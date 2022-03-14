<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void {
        // $product = new Product();
        // $manager->persist($product);
        $whiskasPateeChat = new Products();
        $whiskasPateeChat->setName('WHISKAS® Junior Volaille x12 en Gelée');
        $whiskasPateeChat->setBrand($this->getReference(BrandFixtures::WHISKAS_REFERENCE));
        $whiskasPateeChat->setCategory($this->getReference(CategoryFixtures::FELIN_REFERENCE));
        $whiskasPateeChat->setdescription('Chez WHISKAS®, nous vous aidons à nourrir votre chat à chaque étape de sa vie, avec des repas qu\'il aimera instinctivement.');
        $whiskasPateeChat->setImage('https://s3-eu-west-1.amazonaws.com/w3.cdn.gpd/fr.whiskas.12/large_whiskas-junior-volaille-x12-en-gelee-637359487585710674.png');
        $whiskasPateeChat->setPrice(5.99);
        $whiskasPateeChat->setNbStar(4);
        $whiskasPateeChat->setAvailable(true);
        $whiskasPateeChat->setFlagship(true);

        $purinaCroquetteChat = new Products();
        $purinaCroquetteChat->setName('Purina One Chat adulte Saumon et Céréales');
        $purinaCroquetteChat->setBrand($this->getReference(BrandFixtures::PURINA_REFERENCE));
        $purinaCroquetteChat->setCategory($this->getReference(CategoryFixtures::FELIN_REFERENCE));
        $purinaCroquetteChat->setdescription('Quand le chat atteint l’âge adulte, il est nécessaire de lui servir une alimentation qui comble ses besoins nutritionnels.');
        $purinaCroquetteChat->setImage('https://www.croquetteland.com/on/demandware.static/-/Sites-croquetteland-master/default/dwdab73d9d/18645-CONF/0_full.jpg');
        $purinaCroquetteChat->setPrice(34.99);
        $purinaCroquetteChat->setNbStar(5);
        $purinaCroquetteChat->setAvailable(true);
        $purinaCroquetteChat->setFlagship(true);

        $ankaJouetChat = new Products();
        $ankaJouetChat->setName('Jouet pour Chat Pretty Mice');
        $ankaJouetChat->setBrand($this->getReference(BrandFixtures::ANKA_REFERENCE));
        $ankaJouetChat->setCategory($this->getReference(CategoryFixtures::FELIN_REFERENCE));
        $ankaJouetChat->setdescription('Jouet avec organe sonore imitant le piaillement d\'un oiseau.Au contact de la patte du chat, l\'organe sonore se met en route (s\'arrête au bout de quelques secondes jusqu\'au prochain contact). Des heures d\'amusement pour votre chat ou chaton !');
        $ankaJouetChat->setImage('https://www.croquetteland.com/on/demandware.static/-/Sites-croquetteland-master/default/dwdab73d9d/18645-CONF/0_full.jpg');
        $ankaJouetChat->setPrice(6.95);
        $ankaJouetChat->setNbStar(3);
        $ankaJouetChat->setAvailable(true);
        $ankaJouetChat->setFlagship(true);

        $manager->persist($whiskasPateeChat);
        $manager->persist($purinaCroquetteChat);
        $manager->persist($ankaJouetChat);
        $manager->flush();
    }

    public function getDependencies() {
        return [
            BrandFixtures::class,
            CategoryFixtures::class
        ];
    }
}
