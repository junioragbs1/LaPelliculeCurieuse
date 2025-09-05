<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250905091219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classiques ADD realisateurs VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE films ADD realisateurs VARCHAR(155) NOT NULL');
        $this->addSql('ALTER TABLE series ADD realisateurs VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE films DROP realisateurs');
        $this->addSql('ALTER TABLE classiques DROP realisateurs');
        $this->addSql('ALTER TABLE series DROP realisateurs');
    }
}
