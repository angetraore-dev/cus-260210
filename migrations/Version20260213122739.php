<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213122739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE configuration (id INT AUTO_INCREMENT NOT NULL, contact_email VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, address LONGTEXT NOT NULL, google_maps_link VARCHAR(255) NOT NULL, facebook_link VARCHAR(255) NOT NULL, instagram_link VARCHAR(255) NOT NULL, site_name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dish (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, category_id INT DEFAULT NULL, INDEX IDX_957D8CB812469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, image_title VARCHAR(255) DEFAULT NULL, priority INT NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE opening_hour (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(255) NOT NULL, opening_time TIME NOT NULL, closing_time TIME NOT NULL, is_closed TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB812469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE opening_hour');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
