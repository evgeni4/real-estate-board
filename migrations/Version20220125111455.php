<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125111455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, rating INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6970EB0FA76ED395 (user_id), INDEX IDX_6970EB0FF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, site_name VARCHAR(255) NOT NULL, meta_keywords VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_DB9CEA992C2AC5D3 (translatable_id), UNIQUE INDEX settings_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `userImages` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, file_name_big VARCHAR(255) NOT NULL, file_name_middle VARCHAR(255) NOT NULL, file_name_small VARCHAR(255) NOT NULL, INDEX IDX_8F49AC98A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_covers (id INT AUTO_INCREMENT NOT NULL, user_cover_id INT DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, INDEX IDX_95DFEA8F72AAC2E9 (user_cover_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_banned TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, facebook_id VARCHAR(100) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, about_me LONGTEXT DEFAULT NULL, agency VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, phone VARCHAR(100) NOT NULL, other_phone VARCHAR(100) DEFAULT NULL, fax VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9444F97DD (phone), UNIQUE INDEX UNIQ_1483A5E92CFB6073 (other_phone), UNIQUE INDEX UNIQ_1483A5E99123CD68 (fax), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FF675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE settings_translation ADD CONSTRAINT FK_DB9CEA992C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES settings (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `userImages` ADD CONSTRAINT FK_8F49AC98A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE user_covers ADD CONSTRAINT FK_95DFEA8F72AAC2E9 FOREIGN KEY (user_cover_id) REFERENCES `users` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settings_translation DROP FOREIGN KEY FK_DB9CEA992C2AC5D3');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FF675F31B');
        $this->addSql('ALTER TABLE `userImages` DROP FOREIGN KEY FK_8F49AC98A76ED395');
        $this->addSql('ALTER TABLE user_covers DROP FOREIGN KEY FK_95DFEA8F72AAC2E9');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE settings_translation');
        $this->addSql('DROP TABLE `userImages`');
        $this->addSql('DROP TABLE user_covers');
        $this->addSql('DROP TABLE `users`');
    }
}
