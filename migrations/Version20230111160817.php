<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111160817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE agent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE agent (id INT NOT NULL, poste_id INT NOT NULL, sous_structure_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_268B9C9DA0905086 ON agent (poste_id)');
        $this->addSql('CREATE INDEX IDX_268B9C9D9AA458EE ON agent (sous_structure_id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D9AA458EE FOREIGN KEY (sous_structure_id) REFERENCES sous_structure (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE agent_id_seq CASCADE');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT FK_268B9C9DA0905086');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT FK_268B9C9D9AA458EE');
        $this->addSql('DROP TABLE agent');
    }
}
