<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201092920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7955D4F3F');
        $this->addSql('DROP INDEX IDX_87C331C7955D4F3F ON properties');
        $this->addSql('ALTER TABLE properties DROP extras_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `properties` ADD extras_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C7955D4F3F FOREIGN KEY (extras_id) REFERENCES properties_amenities (id)');
        $this->addSql('CREATE INDEX IDX_87C331C7955D4F3F ON `properties` (extras_id)');
    }
}
