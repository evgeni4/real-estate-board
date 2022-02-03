<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203113806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_rooms_widget_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, room VARCHAR(255) DEFAULT NULL, details LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_C097AB5F2C2AC5D3 (translatable_id), UNIQUE INDEX property_rooms_widget_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_rooms_widget_translation ADD CONSTRAINT FK_C097AB5F2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES `properties_rooms_widgets` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties_rooms_widgets DROP title, DROP room, DROP details');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE property_rooms_widget_translation');
        $this->addSql('ALTER TABLE `properties_rooms_widgets` ADD title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD room VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD details LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
