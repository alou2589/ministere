<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126105849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel DROP CONSTRAINT fk_18d2b09168569149');
        $this->addSql('DROP INDEX idx_18d2b09168569149');
        $this->addSql('ALTER TABLE materiel DROP matos_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE materiel ADD matos_id INT NOT NULL');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT fk_18d2b09168569149 FOREIGN KEY (matos_id) REFERENCES materiel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_18d2b09168569149 ON materiel (matos_id)');
    }
}
