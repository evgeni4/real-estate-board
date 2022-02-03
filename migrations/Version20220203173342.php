<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203173342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties_plan ADD property_plan_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties_plan ADD CONSTRAINT FK_74F6A6FCB15448E3 FOREIGN KEY (property_plan_id) REFERENCES `properties` (id)');
        $this->addSql('CREATE INDEX IDX_74F6A6FCB15448E3 ON properties_plan (property_plan_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `properties_plan` DROP FOREIGN KEY FK_74F6A6FCB15448E3');
        $this->addSql('DROP INDEX IDX_74F6A6FCB15448E3 ON `properties_plan`');
        $this->addSql('ALTER TABLE `properties_plan` DROP property_plan_id');
    }
}
