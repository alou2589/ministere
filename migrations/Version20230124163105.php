<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124163105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE attribution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE attribution (id INT NOT NULL, matos_id INT NOT NULL, agent_id INT NOT NULL, qr_code_attribution TEXT NOT NULL, date_attribution DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C751ED4968569149 ON attribution (matos_id)');
        $this->addSql('CREATE INDEX IDX_C751ED493414710B ON attribution (agent_id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED4968569149 FOREIGN KEY (matos_id) REFERENCES materiel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED493414710B FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE attribution_id_seq CASCADE');
        $this->addSql('ALTER TABLE attribution DROP CONSTRAINT FK_C751ED4968569149');
        $this->addSql('ALTER TABLE attribution DROP CONSTRAINT FK_C751ED493414710B');
        $this->addSql('DROP TABLE attribution');
    }
}
