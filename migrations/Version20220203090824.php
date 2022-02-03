<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203090824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties_rooms_widgets ADD amenity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties_rooms_widgets ADD CONSTRAINT FK_866B58649F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenities (id)');
        $this->addSql('CREATE INDEX IDX_866B58649F9F1305 ON properties_rooms_widgets (amenity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `properties_rooms_widgets` DROP FOREIGN KEY FK_866B58649F9F1305');
        $this->addSql('DROP INDEX IDX_866B58649F9F1305 ON `properties_rooms_widgets`');
        $this->addSql('ALTER TABLE `properties_rooms_widgets` DROP amenity_id');
    }
}
