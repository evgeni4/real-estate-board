<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116145825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `userImages` (id INT AUTO_INCREMENT NOT NULL, file_name_big VARCHAR(255) NOT NULL, file_name_middle VARCHAR(255) NOT NULL, file_name_small VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users ADD user_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9DD28C16D FOREIGN KEY (user_image_id) REFERENCES `userImages` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9DD28C16D ON users (user_image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `users` DROP FOREIGN KEY FK_1483A5E9DD28C16D');
        $this->addSql('DROP TABLE `userImages`');
        $this->addSql('DROP INDEX UNIQ_1483A5E9DD28C16D ON `users`');
        $this->addSql('ALTER TABLE `users` DROP user_image_id');
    }
}
