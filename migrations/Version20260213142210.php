<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213142210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE daily_menu (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE daily_menu_item (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, daily_menu_id INT DEFAULT NULL, INDEX IDX_5650CC4A133638E6 (daily_menu_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE daily_menu_item ADD CONSTRAINT FK_5650CC4A133638E6 FOREIGN KEY (daily_menu_id) REFERENCES daily_menu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_menu_item DROP FOREIGN KEY FK_5650CC4A133638E6');
        $this->addSql('DROP TABLE daily_menu');
        $this->addSql('DROP TABLE daily_menu_item');
    }
}
