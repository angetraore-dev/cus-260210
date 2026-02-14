<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260214162327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_menu_item CHANGE daily_menu_id daily_menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD client_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone VARCHAR(20) DEFAULT NULL, ADD guest_count INT NOT NULL, ADD reservation_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_menu_item CHANGE daily_menu_id daily_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD guest_name VARCHAR(255) NOT NULL, ADD guest_email VARCHAR(255) NOT NULL, ADD guest_phone VARCHAR(255) NOT NULL, DROP client_name, DROP email, DROP phone, CHANGE reservation_at reservation_date DATETIME NOT NULL, CHANGE guest_count nb_persons INT NOT NULL');
    }
}
