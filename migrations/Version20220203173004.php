<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203173004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `properties_plan` (id INT AUTO_INCREMENT NOT NULL, area INT DEFAULT NULL, published TINYINT(1) DEFAULT NULL, image_plan VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_plan_translation` (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, details LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_2864A082C2AC5D3 (translatable_id), UNIQUE INDEX properties_plan_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `properties_plan_translation` ADD CONSTRAINT FK_2864A082C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES `properties_plan` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `properties_plan_translation` DROP FOREIGN KEY FK_2864A082C2AC5D3');
        $this->addSql('DROP TABLE `properties_plan`');
        $this->addSql('DROP TABLE `properties_plan_translation`');
    }
}
