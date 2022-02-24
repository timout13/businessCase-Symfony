<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224131211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_order ADD orders_id INT NOT NULL, ADD price_now DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C4CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_5475E8C4CFFE9AD6 ON product_order (orders_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C4CFFE9AD6');
        $this->addSql('DROP INDEX IDX_5475E8C4CFFE9AD6 ON product_order');
        $this->addSql('ALTER TABLE product_order DROP orders_id, DROP price_now');
    }
}
