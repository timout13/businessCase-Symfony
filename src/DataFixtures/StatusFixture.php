<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $statusAccepted = new Status();
        $statusAccepted->setLabel('Accepté');
        $statusPrepa = new Status();
        $statusPrepa->setLabel('En préparation');
        $statusSend = new Status();
        $statusSend->setLabel('En cours d\'envoi');
        $statusRefound = new Status();
        $statusRefound->setLabel('Remboursement demandé');

        $manager->persist($statusAccepted);
        $manager->persist($statusPrepa);
        $manager->persist($statusSend);
        $manager->persist($statusRefound);

        $manager->flush();
    }
}
