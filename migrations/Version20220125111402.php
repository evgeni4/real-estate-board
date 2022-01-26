<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125111402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_banned TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, facebook_id VARCHAR(100) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, about_me LONGTEXT DEFAULT NULL, agency VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, phone VARCHAR(100) NOT NULL, other_phone VARCHAR(100) DEFAULT NULL, fax VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9444F97DD (phone), UNIQUE INDEX UNIQ_1483A5E92CFB6073 (other_phone), UNIQUE INDEX UNIQ_1483A5E99123CD68 (fax), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FF675F31B');
        $this->addSql('ALTER TABLE `userImages` DROP FOREIGN KEY FK_8F49AC98A76ED395');
        $this->addSql('ALTER TABLE user_covers DROP FOREIGN KEY FK_95DFEA8F72AAC2E9');
        $this->addSql('DROP TABLE `users`');
    }
}
