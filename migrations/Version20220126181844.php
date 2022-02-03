<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126181844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, published TINYINT(1) NOT NULL, area DOUBLE PRECISION DEFAULT NULL, bedrooms INT DEFAULT NULL, bathrooms INT DEFAULT NULL, accommodation INT DEFAULT NULL, yard_size INT DEFAULT NULL, garage INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_8BF21CDE3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, keywords VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_B0C85592C2AC5D3 (translatable_id), UNIQUE INDEX property_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE3414710B FOREIGN KEY (agent_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE property_translation ADD CONSTRAINT FK_B0C85592C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES property (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property_translation DROP FOREIGN KEY FK_B0C85592C2AC5D3');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_translation');
    }
}
