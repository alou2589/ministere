<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125193812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT fk_db021e966c61e1');
        $this->addSql('DROP INDEX idx_db021e966c61e1');
        $this->addSql('ALTER TABLE messages RENAME COLUMN destianataire_id TO destinataire_id');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DB021E96A4F84F6E ON messages (destinataire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96A4F84F6E');
        $this->addSql('DROP INDEX IDX_DB021E96A4F84F6E');
        $this->addSql('ALTER TABLE messages RENAME COLUMN destinataire_id TO destianataire_id');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT fk_db021e966c61e1 FOREIGN KEY (destianataire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_db021e966c61e1 ON messages (destianataire_id)');
    }
}
