<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211208211344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clubes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(300) NOT NULL, total_budget NUMERIC(18, 2) NOT NULL, disponible_budget NUMERIC(18, 2) NOT NULL, enabled BOOLEAN DEFAULT 1, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrenadores (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, description VARCHAR(300) NOT NULL, email VARCHAR(120) NOT NULL, code_country VARCHAR(5) NOT NULL, phone INT NOT NULL, salary NUMERIC(18, 2) NOT NULL, enabled BOOLEAN DEFAULT 1, INDEX IDX_E15FDEE2BF84A342 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jugadores (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(120) NOT NULL, code_country VARCHAR(5) NOT NULL, phone INT NOT NULL, number INT NOT NULL, position VARCHAR(100) NOT NULL, salary NUMERIC(18, 2) NOT NULL, enabled BOOLEAN DEFAULT 1, INDEX IDX_CF491B76BF84A342 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entrenadores ADD CONSTRAINT FK_E15FDEE2BF84A342 FOREIGN KEY (club_id) REFERENCES clubes (id)');
        $this->addSql('ALTER TABLE jugadores ADD CONSTRAINT FK_CF491B76BF84A342 FOREIGN KEY (club_id) REFERENCES clubes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrenadores DROP FOREIGN KEY FK_E15FDEE2BF84A342');
        $this->addSql('ALTER TABLE jugadores DROP FOREIGN KEY FK_CF491B76BF84A342');
        $this->addSql('DROP TABLE clubes');
        $this->addSql('DROP TABLE entrenadores');
        $this->addSql('DROP TABLE jugadores');
    }
}
