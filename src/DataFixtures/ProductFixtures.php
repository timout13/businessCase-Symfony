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
        $whiskasPateeChat->setCategory($this->getReference(CategoryFixtures::FELINNOURRITURE_REFERENCE));
        $whiskasPateeChat->setdescription('Chez WHISKAS®, nous vous aidons à nourrir votre chat à chaque étape de sa vie, avec des repas qu\'il aimera instinctivement.');
        $whiskasPateeChat->setImage('https://s3-eu-west-1.amazonaws.com/w3.cdn.gpd/fr.whiskas.12/large_whiskas-junior-volaille-x12-en-gelee-637359487585710674.png');
        $whiskasPateeChat->setPrice(5.99);
        $whiskasPateeChat->setNbStar(4);
        $whiskasPateeChat->setAvailable(true);
        $whiskasPateeChat->setFlagship(true);

        $purinaCroquetteChat = new Products();
        $purinaCroquetteChat->setName('Purina One Chat adulte Saumon et Céréales');
        $purinaCroquetteChat->setBrand($this->getReference(BrandFixtures::PURINA_REFERENCE));
        $purinaCroquetteChat->setCategory($this->getReference(CategoryFixtures::FELINCROQ_REFERENCE));
        $purinaCroquetteChat->setdescription('Quand le chat atteint l’âge adulte, il est nécessaire de lui servir une alimentation qui comble ses besoins nutritionnels.');
        $purinaCroquetteChat->setImage('https://www.croquetteland.com/on/demandware.static/-/Sites-croquetteland-master/default/dwdab73d9d/18645-CONF/0_full.jpg');
        $purinaCroquetteChat->setPrice(34.99);
        $purinaCroquetteChat->setNbStar(5);
        $purinaCroquetteChat->setAvailable(true);
        $purinaCroquetteChat->setFlagship(true);

        $ankaJouetChat = new Products();
        $ankaJouetChat->setName('Jouet pour Chat Pretty Mice');
        $ankaJouetChat->setBrand($this->getReference(BrandFixtures::ANKA_REFERENCE));
        $ankaJouetChat->setCategory($this->getReference(CategoryFixtures::FELINJOUET_REFERENCE));
        $ankaJouetChat->setdescription('Jouet avec organe sonore imitant le piaillement d\'un oiseau.Au contact de la patte du chat, l\'organe sonore se met en route (s\'arrête au bout de quelques secondes jusqu\'au prochain contact). Des heures d\'amusement pour votre chat ou chaton !');
        $ankaJouetChat->setImage('https://www.croquetteland.com/on/demandware.static/-/Sites-croquetteland-master/default/dwdab73d9d/18645-CONF/0_full.jpg');
        $ankaJouetChat->setPrice(6.95);
        $ankaJouetChat->setNbStar(3);
        $ankaJouetChat->setAvailable(true);
        $ankaJouetChat->setFlagship(true);

        $edgarCooperCroqChien = new Products();
        $edgarCooperCroqChien->setName('Edgard & Cooper - Croquettes BIO à la Dinde et Poulet pour Chien - 2,5Kg');
        $edgarCooperCroqChien->setBrand($this->getReference(BrandFixtures::EDGARDANDCOOPER_REFERENCE));
        $edgarCooperCroqChien->setCategory($this->getReference(CategoryFixtures::CANIDE_REFERENCE));
        $edgarCooperCroqChien->setdescription('Des aliments savoureux avec un maximum de viande fraîche. Des aliments naturels et savoureux bons pour eux, bien pour nous et notre planète.');
        $edgarCooperCroqChien->setImage('https://www.animalis.com/media/catalog/product/cache/85f240ca63119a4567716628ae715af2/4/6/46554_835237.jpg');
        $edgarCooperCroqChien->setPrice(23.95);
        $edgarCooperCroqChien->setNbStar(5);
        $edgarCooperCroqChien->setAvailable(true);
        $edgarCooperCroqChien->setFlagship(true);

        $tetraNourPoisson = new Products();
        $tetraNourPoisson->setName('Tetra - Aliment Complet TetraMin en Flocons pour Poissons Tropicaux - 1L');
        $tetraNourPoisson->setBrand($this->getReference(BrandFixtures::TETRA_REFERENCE));
        $tetraNourPoisson->setCategory($this->getReference(CategoryFixtures::POISSON_REFERENCE));
        $tetraNourPoisson->setdescription('Est composé de plus de 40 substances importantes .Des ingrédients de grande qualité rigoureusement sélectionnés avec apport garanti en vitamines, minéraux et oligo-éléments, pour une alimentation saine et équilibrée.');
        $tetraNourPoisson->setImage('https://www.animalis.com/media/catalog/product/cache/85f240ca63119a4567716628ae715af2/6/0/6083_009794.jpg');
        $tetraNourPoisson->setPrice(18.50);
        $tetraNourPoisson->setNbStar(4);
        $tetraNourPoisson->setAvailable(true);
        $tetraNourPoisson->setFlagship(true);

        $paradisioNourRongeur = new Products();
        $paradisioNourRongeur->setName('Paradisio - Aliment Complet pour Lapins Nains Junior - 900g');
        $paradisioNourRongeur->setBrand($this->getReference(BrandFixtures::PARADISIO_REFERENCE));
        $paradisioNourRongeur->setCategory($this->getReference(CategoryFixtures::RONGEUR_REFERENCE));
        $paradisioNourRongeur->setdescription('Avec ce mélange complet spécialement étudié pour les jeunes lapins, vous n\'aurez aucune crainte de mauvaise alimentation.');
        $paradisioNourRongeur->setImage('https://www.animalis.com/media/catalog/product/cache/85f240ca63119a4567716628ae715af2/5/7/5796_032741_1.jpg');
        $paradisioNourRongeur->setPrice(5.50);
        $paradisioNourRongeur->setNbStar(4);
        $paradisioNourRongeur->setAvailable(true);
        $paradisioNourRongeur->setFlagship(true);

        $paradisioNourVolatile = new Products();
        $paradisioNourVolatile->setName('Paradisio - Mélange de Graines pour Canaris - 1Kg');
        $paradisioNourVolatile->setBrand($this->getReference(BrandFixtures::PARADISIO_REFERENCE));
        $paradisioNourVolatile->setCategory($this->getReference(CategoryFixtures::VOLATILE_REFERENCE));
        $paradisioNourVolatile->setdescription('Ce mélange paradisio spécialement étudié pour les canaris convient en alimentation principale. Il les ravira d\'autant plus qu\'il contient leur graine favorite : le millet !');
        $paradisioNourVolatile->setImage('https://www.animalis.com/media/catalog/product/cache/85f240ca63119a4567716628ae715af2/1/4/1449_044209_1.jpg');
        $paradisioNourVolatile->setPrice(3.95);
        $paradisioNourVolatile->setNbStar(2);
        $paradisioNourVolatile->setAvailable(true);
        $paradisioNourVolatile->setFlagship(true);

        $manager->persist($whiskasPateeChat);
        $manager->persist($purinaCroquetteChat);
        $manager->persist($ankaJouetChat);
        $manager->persist($edgarCooperCroqChien);
        $manager->persist($tetraNourPoisson);
        $manager->persist($paradisioNourRongeur);
        $manager->persist($paradisioNourVolatile);
        $manager->flush();
    }

    public function getDependencies() {
        return [
            BrandFixtures::class,
            CategoryFixtures::class
        ];
    }
}
