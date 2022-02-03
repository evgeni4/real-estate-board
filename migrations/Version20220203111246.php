<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203111246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `properties_rooms_widget_amenities` (id INT AUTO_INCREMENT NOT NULL, rooms_widget_id INT DEFAULT NULL, amenity_id INT DEFAULT NULL, INDEX IDX_78056028E0049F3 (rooms_widget_id), INDEX IDX_780560289F9F1305 (amenity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `properties_rooms_widget_amenities` ADD CONSTRAINT FK_78056028E0049F3 FOREIGN KEY (rooms_widget_id) REFERENCES `properties_rooms_widgets` (id)');
        $this->addSql('ALTER TABLE `properties_rooms_widget_amenities` ADD CONSTRAINT FK_780560289F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenities (id)');
        $this->addSql('ALTER TABLE properties_rooms_widgets DROP FOREIGN KEY FK_866B58649F9F1305');
        $this->addSql('DROP INDEX IDX_866B58649F9F1305 ON properties_rooms_widgets');
        $this->addSql('ALTER TABLE properties_rooms_widgets DROP amenity_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `properties_rooms_widget_amenities`');
        $this->addSql('ALTER TABLE `properties_rooms_widgets` ADD amenity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `properties_rooms_widgets` ADD CONSTRAINT FK_866B58649F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenities (id)');
        $this->addSql('CREATE INDEX IDX_866B58649F9F1305 ON `properties_rooms_widgets` (amenity_id)');
    }
}
