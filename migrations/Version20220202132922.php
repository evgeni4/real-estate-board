<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202132922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `properties_images` (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, image_sm VARCHAR(255) DEFAULT NULL, image_md VARCHAR(255) DEFAULT NULL, image_lg VARCHAR(255) DEFAULT NULL, INDEX IDX_18B306D549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `properties_images` ADD CONSTRAINT FK_18B306D549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
        $this->addSql('DROP TABLE properties_image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE properties_image (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, image_sm VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_md VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_lg VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5F2B1B14549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE properties_image ADD CONSTRAINT FK_5F2B1B14549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('DROP TABLE `properties_images`');
    }
}
