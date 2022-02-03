<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201095133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties_amenities ADD property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties_amenities ADD CONSTRAINT FK_BC5DA08B549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
        $this->addSql('CREATE INDEX IDX_BC5DA08B549213EC ON properties_amenities (property_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `properties_amenities` DROP FOREIGN KEY FK_BC5DA08B549213EC');
        $this->addSql('DROP INDEX IDX_BC5DA08B549213EC ON `properties_amenities`');
        $this->addSql('ALTER TABLE `properties_amenities` DROP property_id');
    }
}
