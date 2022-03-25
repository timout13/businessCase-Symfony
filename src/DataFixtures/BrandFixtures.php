<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public const WHISKAS_REFERENCE = 'whiskas';
    public const PEDIGREE_REFERENCE = 'pedigree';
    public const ROYALCANIN_REFERENCE = 'royalcanin';
    public const PURINA_REFERENCE = 'purina';
    public const FROLIC_REFERENCE = 'frolic';
    public const ANKA_REFERENCE = 'anka';
    public const EDGARDANDCOOPER_REFERENCE = 'edgardAndCooper';
    public const TETRA_REFERENCE = 'tetra';
    public const PARADISIO_REFERENCE = 'paradisio';
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $whiskas = new Brand();
        $whiskas->setLabel('Whiskas');
        $this->addReference(self::WHISKAS_REFERENCE, $whiskas);

        $pedigree = new Brand();
        $pedigree->setLabel('Pedigree');
        $this->addReference(self::PEDIGREE_REFERENCE, $pedigree);

        $royalcanin = new Brand();
        $royalcanin->setLabel('Royal Canin');
        $this->addReference(self::ROYALCANIN_REFERENCE, $royalcanin);

        $purina = new Brand();
        $purina->setLabel('Purina');
        $this->addReference(self::PURINA_REFERENCE, $purina);

        $frolic = new Brand();
        $frolic->setLabel('Frolic');
        $this->addReference(self::FROLIC_REFERENCE, $frolic);

        $anka = new Brand();
        $anka->setLabel('Anka');
        $this->addReference(self::ANKA_REFERENCE, $anka);

        $edgardAndCooper = new Brand();
        $edgardAndCooper->setLabel('Edgard & Cooper');
        $this->addReference(self::EDGARDANDCOOPER_REFERENCE, $edgardAndCooper);

        $tetra = new Brand();
        $tetra->setLabel('Tetra');
        $this->addReference(self::TETRA_REFERENCE, $tetra);

        $paradisio = new Brand();
        $paradisio->setLabel('Paradisio');
        $this->addReference(self::PARADISIO_REFERENCE, $paradisio);

        $manager->persist($whiskas);
        $manager->persist($pedigree);
        $manager->persist($royalcanin);
        $manager->persist($purina);
        $manager->persist($frolic);
        $manager->persist($anka);
        $manager->persist($edgardAndCooper);
        $manager->persist($tetra);
        $manager->persist($paradisio);
        $manager->flush();
    }
}
