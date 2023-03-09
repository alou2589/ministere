<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111161645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE statut_agent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE statut_agent (id INT NOT NULL, agent_id INT NOT NULL, echellon VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, hierarchie VARCHAR(255) NOT NULL, date_prise_service DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1476F3E33414710B ON statut_agent (agent_id)');
        $this->addSql('ALTER TABLE statut_agent ADD CONSTRAINT FK_1476F3E33414710B FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE statut_agent_id_seq CASCADE');
        $this->addSql('ALTER TABLE statut_agent DROP CONSTRAINT FK_1476F3E33414710B');
        $this->addSql('DROP TABLE statut_agent');
    }
}
