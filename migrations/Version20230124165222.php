<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124165222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE technicien_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE technicien (id INT NOT NULL, info_technicien_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_96282C4C5BDA99CA ON technicien (info_technicien_id)');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, matos_id INT NOT NULL, technicien_id INT NOT NULL, description_proprietaire TEXT NOT NULL, date_declaration TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, observation_technicien TEXT NOT NULL, solution_apportée TEXT NOT NULL, date_sortie TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status_ticket VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA368569149 ON ticket (matos_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA313457256 ON ticket (technicien_id)');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4C5BDA99CA FOREIGN KEY (info_technicien_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA368569149 FOREIGN KEY (matos_id) REFERENCES materiel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA313457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE technicien_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('ALTER TABLE technicien DROP CONSTRAINT FK_96282C4C5BDA99CA');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA368569149');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA313457256');
        $this->addSql('DROP TABLE technicien');
        $this->addSql('DROP TABLE ticket');
    }
}
