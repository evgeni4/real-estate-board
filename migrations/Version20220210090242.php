<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220210090242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amenities (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', published TINYINT(1) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amenities_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_3C4BABE22C2AC5D3 (translatable_id), UNIQUE INDEX amenities_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, keywords LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_3F207042C2AC5D3 (translatable_id), UNIQUE INDEX category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `cities` (id INT AUTO_INCREMENT NOT NULL, state_id INT DEFAULT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D95DB16B5D83CC1 (state_id), INDEX IDX_D95DB16BF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `countries` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_type_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_C0B8F212C2AC5D3 (translatable_id), UNIQUE INDEX price_type_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prices_types (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, INDEX IDX_968C9E14C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties` (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, types_id INT DEFAULT NULL, category_id INT DEFAULT NULL, country_id INT DEFAULT NULL, state_id INT DEFAULT NULL, city_id INT DEFAULT NULL, period_id INT DEFAULT NULL, checked TINYINT(1) NOT NULL, uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', price NUMERIC(10, 0) NOT NULL, published TINYINT(1) NOT NULL, area DOUBLE PRECISION DEFAULT NULL, bedrooms INT DEFAULT NULL, bathrooms INT DEFAULT NULL, accommodation INT DEFAULT NULL, yard_size INT DEFAULT NULL, garage INT DEFAULT NULL, latitude TINYTEXT DEFAULT NULL, longitude TINYTEXT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, reference_number BIGINT NOT NULL, room_widget_status TINYINT(1) NOT NULL, property_plan_status TINYINT(1) NOT NULL, video VARCHAR(255) DEFAULT NULL, video_presentation TINYINT(1) DEFAULT NULL, contact_form_status TINYINT(1) DEFAULT NULL, google_map_status TINYINT(1) DEFAULT NULL, floors INT DEFAULT NULL, viewed INT DEFAULT NULL, INDEX IDX_87C331C73414710B (agent_id), INDEX IDX_87C331C78EB23357 (types_id), INDEX IDX_87C331C712469DE2 (category_id), INDEX IDX_87C331C7F92F3E70 (country_id), INDEX IDX_87C331C75D83CC1 (state_id), INDEX IDX_87C331C78BAC62AF (city_id), INDEX IDX_87C331C7EC8B7ADE (period_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_amenities` (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, amenity_id INT DEFAULT NULL, checked TINYINT(1) NOT NULL, INDEX IDX_BC5DA08B549213EC (property_id), INDEX IDX_BC5DA08B9F9F1305 (amenity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_images` (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, image_sm VARCHAR(255) DEFAULT NULL, image_md VARCHAR(255) DEFAULT NULL, image_lg VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_18B306D549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_plan` (id INT AUTO_INCREMENT NOT NULL, property_plan_id INT DEFAULT NULL, area INT DEFAULT NULL, published TINYINT(1) DEFAULT NULL, image_plan VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_74F6A6FCB15448E3 (property_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_plan_translation` (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, details LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_2864A082C2AC5D3 (translatable_id), UNIQUE INDEX properties_plan_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_rooms_widget_amenities` (id INT AUTO_INCREMENT NOT NULL, rooms_widget_id INT DEFAULT NULL, amenity_id INT DEFAULT NULL, INDEX IDX_78056028E0049F3 (rooms_widget_id), INDEX IDX_780560289F9F1305 (amenity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_rooms_widgets` (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, published TINYINT(1) NOT NULL, image_room VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, area INT DEFAULT NULL, INDEX IDX_866B5864549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_rooms_widgets_translation` (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, room VARCHAR(255) DEFAULT NULL, details LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_3FB51AC52C2AC5D3 (translatable_id), UNIQUE INDEX properties_rooms_widgets_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `properties_translation` (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, keywords VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_B6B08AF62C2AC5D3 (translatable_id), UNIQUE INDEX properties_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, author_id INT DEFAULT NULL, property_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, rating INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6970EB0FA76ED395 (user_id), INDEX IDX_6970EB0FF675F31B (author_id), INDEX IDX_6970EB0F549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, site_name VARCHAR(255) NOT NULL, meta_keywords VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_DB9CEA992C2AC5D3 (translatable_id), UNIQUE INDEX settings_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `states` (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_31C2774DF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_FF7092FE2C2AC5D3 (translatable_id), UNIQUE INDEX type_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', published TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `userImages` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, file_name_big VARCHAR(255) NOT NULL, file_name_middle VARCHAR(255) NOT NULL, file_name_small VARCHAR(255) NOT NULL, INDEX IDX_8F49AC98A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_covers (id INT AUTO_INCREMENT NOT NULL, user_cover_id INT DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, INDEX IDX_95DFEA8F72AAC2E9 (user_cover_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_banned TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, facebook_id VARCHAR(100) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, about_me LONGTEXT DEFAULT NULL, agency VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, phone VARCHAR(100) DEFAULT NULL, other_phone VARCHAR(100) DEFAULT NULL, fax VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9444F97DD (phone), UNIQUE INDEX UNIQ_1483A5E92CFB6073 (other_phone), UNIQUE INDEX UNIQ_1483A5E99123CD68 (fax), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amenities_translation ADD CONSTRAINT FK_3C4BABE22C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES amenities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_translation ADD CONSTRAINT FK_3F207042C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `cities` ADD CONSTRAINT FK_D95DB16B5D83CC1 FOREIGN KEY (state_id) REFERENCES `states` (id)');
        $this->addSql('ALTER TABLE `cities` ADD CONSTRAINT FK_D95DB16BF92F3E70 FOREIGN KEY (country_id) REFERENCES `countries` (id)');
        $this->addSql('ALTER TABLE price_type_translation ADD CONSTRAINT FK_C0B8F212C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES prices_types (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prices_types ADD CONSTRAINT FK_968C9E14C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C73414710B FOREIGN KEY (agent_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C78EB23357 FOREIGN KEY (types_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C712469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C7F92F3E70 FOREIGN KEY (country_id) REFERENCES `countries` (id)');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C75D83CC1 FOREIGN KEY (state_id) REFERENCES `states` (id)');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C78BAC62AF FOREIGN KEY (city_id) REFERENCES `cities` (id)');
        $this->addSql('ALTER TABLE `properties` ADD CONSTRAINT FK_87C331C7EC8B7ADE FOREIGN KEY (period_id) REFERENCES prices_types (id)');
        $this->addSql('ALTER TABLE `properties_amenities` ADD CONSTRAINT FK_BC5DA08B549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
        $this->addSql('ALTER TABLE `properties_amenities` ADD CONSTRAINT FK_BC5DA08B9F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenities (id)');
        $this->addSql('ALTER TABLE `properties_images` ADD CONSTRAINT FK_18B306D549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
        $this->addSql('ALTER TABLE `properties_plan` ADD CONSTRAINT FK_74F6A6FCB15448E3 FOREIGN KEY (property_plan_id) REFERENCES `properties` (id)');
        $this->addSql('ALTER TABLE `properties_plan_translation` ADD CONSTRAINT FK_2864A082C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES `properties_plan` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `properties_rooms_widget_amenities` ADD CONSTRAINT FK_78056028E0049F3 FOREIGN KEY (rooms_widget_id) REFERENCES `properties_rooms_widgets` (id)');
        $this->addSql('ALTER TABLE `properties_rooms_widget_amenities` ADD CONSTRAINT FK_780560289F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenities (id)');
        $this->addSql('ALTER TABLE `properties_rooms_widgets` ADD CONSTRAINT FK_866B5864549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
        $this->addSql('ALTER TABLE `properties_rooms_widgets_translation` ADD CONSTRAINT FK_3FB51AC52C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES `properties_rooms_widgets` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `properties_translation` ADD CONSTRAINT FK_B6B08AF62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES `properties` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FF675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F549213EC FOREIGN KEY (property_id) REFERENCES `properties` (id)');
        $this->addSql('ALTER TABLE settings_translation ADD CONSTRAINT FK_DB9CEA992C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES settings (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `states` ADD CONSTRAINT FK_31C2774DF92F3E70 FOREIGN KEY (country_id) REFERENCES `countries` (id)');
        $this->addSql('ALTER TABLE type_translation ADD CONSTRAINT FK_FF7092FE2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES types (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `userImages` ADD CONSTRAINT FK_8F49AC98A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE user_covers ADD CONSTRAINT FK_95DFEA8F72AAC2E9 FOREIGN KEY (user_cover_id) REFERENCES `users` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amenities_translation DROP FOREIGN KEY FK_3C4BABE22C2AC5D3');
        $this->addSql('ALTER TABLE `properties_amenities` DROP FOREIGN KEY FK_BC5DA08B9F9F1305');
        $this->addSql('ALTER TABLE `properties_rooms_widget_amenities` DROP FOREIGN KEY FK_780560289F9F1305');
        $this->addSql('ALTER TABLE category_translation DROP FOREIGN KEY FK_3F207042C2AC5D3');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C712469DE2');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C78BAC62AF');
        $this->addSql('ALTER TABLE `cities` DROP FOREIGN KEY FK_D95DB16BF92F3E70');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C7F92F3E70');
        $this->addSql('ALTER TABLE `states` DROP FOREIGN KEY FK_31C2774DF92F3E70');
        $this->addSql('ALTER TABLE price_type_translation DROP FOREIGN KEY FK_C0B8F212C2AC5D3');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C7EC8B7ADE');
        $this->addSql('ALTER TABLE `properties_amenities` DROP FOREIGN KEY FK_BC5DA08B549213EC');
        $this->addSql('ALTER TABLE `properties_images` DROP FOREIGN KEY FK_18B306D549213EC');
        $this->addSql('ALTER TABLE `properties_plan` DROP FOREIGN KEY FK_74F6A6FCB15448E3');
        $this->addSql('ALTER TABLE `properties_rooms_widgets` DROP FOREIGN KEY FK_866B5864549213EC');
        $this->addSql('ALTER TABLE `properties_translation` DROP FOREIGN KEY FK_B6B08AF62C2AC5D3');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F549213EC');
        $this->addSql('ALTER TABLE `properties_plan_translation` DROP FOREIGN KEY FK_2864A082C2AC5D3');
        $this->addSql('ALTER TABLE `properties_rooms_widget_amenities` DROP FOREIGN KEY FK_78056028E0049F3');
        $this->addSql('ALTER TABLE `properties_rooms_widgets_translation` DROP FOREIGN KEY FK_3FB51AC52C2AC5D3');
        $this->addSql('ALTER TABLE settings_translation DROP FOREIGN KEY FK_DB9CEA992C2AC5D3');
        $this->addSql('ALTER TABLE `cities` DROP FOREIGN KEY FK_D95DB16B5D83CC1');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C75D83CC1');
        $this->addSql('ALTER TABLE prices_types DROP FOREIGN KEY FK_968C9E14C54C8C93');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C78EB23357');
        $this->addSql('ALTER TABLE type_translation DROP FOREIGN KEY FK_FF7092FE2C2AC5D3');
        $this->addSql('ALTER TABLE `properties` DROP FOREIGN KEY FK_87C331C73414710B');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FF675F31B');
        $this->addSql('ALTER TABLE `userImages` DROP FOREIGN KEY FK_8F49AC98A76ED395');
        $this->addSql('ALTER TABLE user_covers DROP FOREIGN KEY FK_95DFEA8F72AAC2E9');
        $this->addSql('DROP TABLE amenities');
        $this->addSql('DROP TABLE amenities_translation');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE category_translation');
        $this->addSql('DROP TABLE `cities`');
        $this->addSql('DROP TABLE `countries`');
        $this->addSql('DROP TABLE price_type_translation');
        $this->addSql('DROP TABLE prices_types');
        $this->addSql('DROP TABLE `properties`');
        $this->addSql('DROP TABLE `properties_amenities`');
        $this->addSql('DROP TABLE `properties_images`');
        $this->addSql('DROP TABLE `properties_plan`');
        $this->addSql('DROP TABLE `properties_plan_translation`');
        $this->addSql('DROP TABLE `properties_rooms_widget_amenities`');
        $this->addSql('DROP TABLE `properties_rooms_widgets`');
        $this->addSql('DROP TABLE `properties_rooms_widgets_translation`');
        $this->addSql('DROP TABLE `properties_translation`');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE settings_translation');
        $this->addSql('DROP TABLE `states`');
        $this->addSql('DROP TABLE type_translation');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP TABLE `userImages`');
        $this->addSql('DROP TABLE user_covers');
        $this->addSql('DROP TABLE `users`');
    }
}
