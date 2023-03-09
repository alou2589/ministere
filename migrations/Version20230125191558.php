<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125191558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT fk_db021e9610335f61');
        $this->addSql('DROP INDEX idx_db021e9610335f61');
        $this->addSql('ALTER TABLE messages RENAME COLUMN expediteur_id TO destianataire_id');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E966C61E1 FOREIGN KEY (destianataire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DB021E966C61E1 ON messages (destianataire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E966C61E1');
        $this->addSql('DROP INDEX IDX_DB021E966C61E1');
        $this->addSql('ALTER TABLE messages RENAME COLUMN destianataire_id TO expediteur_id');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT fk_db021e9610335f61 FOREIGN KEY (expediteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_db021e9610335f61 ON messages (expediteur_id)');
    }
}
