<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201095345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties_amenities DROP FOREIGN KEY FK_BC5DA08B549213EC');
        $this->addSql('ALTER TABLE properties_amenities DROP FOREIGN KEY FK_BC5DA08BB92D5262');
        $this->addSql('DROP INDEX IDX_BC5DA08BB92D5262 ON properties_amenities');
        $this->addSql('DROP INDEX IDX_BC5DA08B549213EC ON properties_amenities');
        $this->addSql('ALTER TABLE properties_amenities DROP amenities_id, DROP property_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `properties_amenities` ADD amenities_id INT DEFAULT NULL, ADD property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `properties_amenities` ADD CONSTRAINT FK_BC5DA08B549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE `properties_amenities` ADD CONSTRAINT FK_BC5DA08BB92D5262 FOREIGN KEY (amenities_id) REFERENCES amenities (id)');
        $this->addSql('CREATE INDEX IDX_BC5DA08BB92D5262 ON `properties_amenities` (amenities_id)');
        $this->addSql('CREATE INDEX IDX_BC5DA08B549213EC ON `properties_amenities` (property_id)');
    }
}
