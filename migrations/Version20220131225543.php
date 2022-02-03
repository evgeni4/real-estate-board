<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131225543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `properties_amenities` (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, amenities INT NOT NULL, INDEX IDX_BC5DA08B549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `properties_amenities` ADD CONSTRAINT FK_BC5DA08B549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
        $this->addSql('DROP TABLE property_amenities');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_amenities (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, amenities INT NOT NULL, INDEX IDX_9A9F56CA549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE property_amenities ADD CONSTRAINT FK_9A9F56CA549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('DROP TABLE `properties_amenities`');
    }
}
