<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131225640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `properties_translation` (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, keywords VARCHAR(255) NOT NULL, description TINYTEXT NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_B6B08AF62C2AC5D3 (translatable_id), UNIQUE INDEX properties_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `properties_translation` ADD CONSTRAINT FK_B6B08AF62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES `properties` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE property_amenities');
        $this->addSql('DROP TABLE property_translation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_amenities (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, amenities INT NOT NULL, INDEX IDX_9A9F56CA549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE property_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, keywords VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, locale VARCHAR(5) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description TINYTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX property_translation_unique_translation (translatable_id, locale), INDEX IDX_B0C85592C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE property_amenities ADD CONSTRAINT FK_9A9F56CA549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE property_translation ADD CONSTRAINT FK_B0C85592C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE `properties_translation`');
    }
}
