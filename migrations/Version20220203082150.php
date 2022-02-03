<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203082150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `properties_rooms_widgets` (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, room VARCHAR(255) DEFAULT NULL, details LONGTEXT DEFAULT NULL, published TINYINT(1) NOT NULL, INDEX IDX_866B5864549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `properties_rooms_widgets` ADD CONSTRAINT FK_866B5864549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `properties_rooms_widgets`');
    }
}
