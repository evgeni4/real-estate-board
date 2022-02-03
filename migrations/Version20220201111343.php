<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201111343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amenities ADD property_amenities_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE amenities ADD CONSTRAINT FK_EB7054777628A23B FOREIGN KEY (property_amenities_id) REFERENCES `properties_amenities` (id)');
        $this->addSql('CREATE INDEX IDX_EB7054777628A23B ON amenities (property_amenities_id)');
        $this->addSql('ALTER TABLE properties_amenities DROP FOREIGN KEY FK_BC5DA08B9F9F1305');
        $this->addSql('DROP INDEX IDX_BC5DA08B9F9F1305 ON properties_amenities');
        $this->addSql('ALTER TABLE properties_amenities DROP amenity_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amenities DROP FOREIGN KEY FK_EB7054777628A23B');
        $this->addSql('DROP INDEX IDX_EB7054777628A23B ON amenities');
        $this->addSql('ALTER TABLE amenities DROP property_amenities_id');
        $this->addSql('ALTER TABLE `properties_amenities` ADD amenity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `properties_amenities` ADD CONSTRAINT FK_BC5DA08B9F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenities (id)');
        $this->addSql('CREATE INDEX IDX_BC5DA08B9F9F1305 ON `properties_amenities` (amenity_id)');
    }
}
