<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116150401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE userImages ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE userImages ADD CONSTRAINT FK_8F49AC98A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('CREATE INDEX IDX_8F49AC98A76ED395 ON userImages (user_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9DD28C16D');
        $this->addSql('DROP INDEX UNIQ_1483A5E9DD28C16D ON users');
        $this->addSql('ALTER TABLE users DROP user_image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `userImages` DROP FOREIGN KEY FK_8F49AC98A76ED395');
        $this->addSql('DROP INDEX IDX_8F49AC98A76ED395 ON `userImages`');
        $this->addSql('ALTER TABLE `userImages` DROP user_id');
        $this->addSql('ALTER TABLE `users` ADD user_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `users` ADD CONSTRAINT FK_1483A5E9DD28C16D FOREIGN KEY (user_image_id) REFERENCES userImages (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9DD28C16D ON `users` (user_image_id)');
    }
}
