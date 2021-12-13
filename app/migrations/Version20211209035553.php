<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209035553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clubes CHANGE enabled enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE entrenadores CHANGE enabled enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE entrenadores RENAME INDEX idx_e15fdee2bf84a342 TO IDX_E15FDEE261190A32');
        $this->addSql('ALTER TABLE jugadores CHANGE enabled enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE jugadores RENAME INDEX idx_cf491b76bf84a342 TO IDX_CF491B7661190A32');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clubes CHANGE enabled enabled TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE entrenadores CHANGE enabled enabled TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE entrenadores RENAME INDEX idx_e15fdee261190a32 TO IDX_E15FDEE2BF84A342');
        $this->addSql('ALTER TABLE jugadores CHANGE enabled enabled TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE jugadores RENAME INDEX idx_cf491b7661190a32 TO IDX_CF491B76BF84A342');
    }
}
