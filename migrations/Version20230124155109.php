<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124155109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE messages (id INT NOT NULL, expediteur_id INT NOT NULL, destinataire_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu TEXT NOT NULL, date_envoi DATE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB021E9610335F61 ON messages (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96A4F84F6E ON messages (destinataire_id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9610335F61 FOREIGN KEY (expediteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE messages_id_seq CASCADE');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E9610335F61');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96A4F84F6E');
        $this->addSql('DROP TABLE messages');
    }
}
