<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120094143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE userImages ADD user_cover_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE userImages ADD CONSTRAINT FK_8F49AC9872AAC2E9 FOREIGN KEY (user_cover_id) REFERENCES `users` (id)');
        $this->addSql('CREATE INDEX IDX_8F49AC9872AAC2E9 ON userImages (user_cover_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `userImages` DROP FOREIGN KEY FK_8F49AC9872AAC2E9');
        $this->addSql('DROP INDEX IDX_8F49AC9872AAC2E9 ON `userImages`');
        $this->addSql('ALTER TABLE `userImages` DROP user_cover_id');
    }
}
