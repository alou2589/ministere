<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117122846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE carte_professionnelle_id_seq CASCADE');
        $this->addSql('ALTER TABLE carte_professionnelle DROP CONSTRAINT fk_157320ea3414710b');
        $this->addSql('DROP TABLE carte_professionnelle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE carte_professionnelle_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE carte_professionnelle (id INT NOT NULL, agent_id INT NOT NULL, date_delivrance DATE NOT NULL, date_expiration DATE NOT NULL, status_carte INT NOT NULL, qrcode_agent TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_157320ea3414710b ON carte_professionnelle (agent_id)');
        $this->addSql('ALTER TABLE carte_professionnelle ADD CONSTRAINT fk_157320ea3414710b FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
