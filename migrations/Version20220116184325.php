<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116184325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `userImages` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, file_name_big VARCHAR(255) NOT NULL, file_name_middle VARCHAR(255) NOT NULL, file_name_small VARCHAR(255) NOT NULL, INDEX IDX_8F49AC98A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `userImages` ADD CONSTRAINT FK_8F49AC98A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE settings DROP site_name, DROP meta_keywords, DROP meta_description');
        $this->addSql('ALTER TABLE settings_translation ADD site_name VARCHAR(255) NOT NULL, ADD meta_keywords VARCHAR(255) NOT NULL, ADD meta_description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE users ADD phone VARCHAR(25) DEFAULT NULL, ADD about_me LONGTEXT DEFAULT NULL, ADD agency VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9444F97DD ON users (phone)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `userImages`');
        $this->addSql('ALTER TABLE settings ADD site_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD meta_keywords VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD meta_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE settings_translation DROP site_name, DROP meta_keywords, DROP meta_description');
        $this->addSql('DROP INDEX UNIQ_1483A5E9444F97DD ON `users`');
        $this->addSql('ALTER TABLE `users` DROP phone, DROP about_me, DROP agency, DROP created_at');
    }
}
