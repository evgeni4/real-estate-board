<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220311120709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_pricing_plan (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, pricing_plan_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', valid_date DATE NOT NULL, INDEX IDX_76802DC1A76ED395 (user_id), INDEX IDX_76802DC129628C71 (pricing_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_pricing_plan ADD CONSTRAINT FK_76802DC1A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE user_pricing_plan ADD CONSTRAINT FK_76802DC129628C71 FOREIGN KEY (pricing_plan_id) REFERENCES pricing_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_pricing_plan');
    }
}
