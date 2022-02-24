<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224134425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD birthday VARCHAR(255) NOT NULL, ADD genre VARCHAR(255) NOT NULL, ADD nb_street VARCHAR(255) NOT NULL, ADD address_line VARCHAR(255) NOT NULL, ADD post_code VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP birthday, DROP genre, DROP nb_street, DROP address_line, DROP post_code, DROP city');
    }
}
