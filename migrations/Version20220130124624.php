<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130124624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties ADD state_id INT DEFAULT NULL, ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C75D83CC1 FOREIGN KEY (state_id) REFERENCES `states` (id)');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C78BAC62AF FOREIGN KEY (city_id) REFERENCES `cities` (id)');
        $this->addSql('CREATE INDEX IDX_87C331C75D83CC1 ON properties (state_id)');
        $this->addSql('CREATE INDEX IDX_87C331C78BAC62AF ON properties (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C75D83CC1');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C78BAC62AF');
        $this->addSql('DROP INDEX IDX_87C331C75D83CC1 ON `properties`');
        $this->addSql('DROP INDEX IDX_87C331C78BAC62AF ON `properties`');
        $this->addSql('ALTER TABLE `properties` DROP state_id, DROP city_id');
    }
}
