<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125111307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9444F97DD ON users (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E92CFB6073 ON users (other_phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E99123CD68 ON users (fax)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1483A5E9444F97DD ON `users`');
        $this->addSql('DROP INDEX UNIQ_1483A5E92CFB6073 ON `users`');
        $this->addSql('DROP INDEX UNIQ_1483A5E99123CD68 ON `users`');
    }
}
