<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201135013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_amenities_amenities (property_amenities_id INT NOT NULL, amenities_id INT NOT NULL, INDEX IDX_7521DCD17628A23B (property_amenities_id), INDEX IDX_7521DCD1B92D5262 (amenities_id), PRIMARY KEY(property_amenities_id, amenities_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_amenities_amenities ADD CONSTRAINT FK_7521DCD17628A23B FOREIGN KEY (property_amenities_id) REFERENCES `properties_amenities` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_amenities_amenities ADD CONSTRAINT FK_7521DCD1B92D5262 FOREIGN KEY (amenities_id) REFERENCES amenities (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE property_amenities_amenities');
    }
}
