<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120104355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_covers (id INT AUTO_INCREMENT NOT NULL, user_cover_id INT DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_95DFEA8F72AAC2E9 (user_cover_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_covers ADD CONSTRAINT FK_95DFEA8F72AAC2E9 FOREIGN KEY (user_cover_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE userImages DROP cover');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_covers');
        $this->addSql('ALTER TABLE `userImages` ADD cover VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
