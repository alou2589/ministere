<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125191207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT fk_db021e96a4f84f6e');
        $this->addSql('DROP INDEX idx_db021e96a4f84f6e');
        $this->addSql('ALTER TABLE messages DROP destinataire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE messages ADD destinataire_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT fk_db021e96a4f84f6e FOREIGN KEY (destinataire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_db021e96a4f84f6e ON messages (destinataire_id)');
    }
}
